<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AskAvailability;
use App\Http\Resources\AskAvailableResource;
use App\Models\User;

class AskAvailabilityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get user_id
        $user_id = auth('sanctum')->user()->id;

        $validator = Validator::make($request->all(),[
            'property_id'   => 'required|numeric',
            'start_period'  => 'required|date',
        ]);

        if($validator->fails()){
            $result = Array(
                'success' => FALSE,
                'message' => 'Error',
                'data' => $validator->errors()
            );
            return response()->json($result);
        }

        // check user's remaining credits
        $user = User::find($user_id);

        if ($user->credit >= 5){
            // reduce 5 points
            $user->credit = $user->credit - 5;
            $user->save();

            // store ask availability
            $askAvailability = AskAvailability::create([
                'user_id'       => $user_id,
                'property_id'   => $request->property_id,
                'is_available'  => 0,
                'start_period'  => $request->start_period,
            ]);

            $result = Array(
                'success' => TRUE,
                'message' => 'Ask availability created successfully. Your credit reduced 5 points. Your remaining credit = ' . $user->credit,
                'data' => new AskAvailableResource($askAvailability)
            );
        } else {
            $result = Array(
                'success' => FALSE,
                'message' => 'Insufficient credit',
            );
        }

        return response()->json($result);
    }
}
