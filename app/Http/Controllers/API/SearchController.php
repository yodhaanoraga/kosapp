<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Properties;
use App\Http\Resources\PropertyResource;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * Param keyword
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'keyword'   => 'string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        if (empty($request->keyword) OR $request->keyword == ""){
            // if no keyword, list all order by price asc
            $data = Properties::orderBy("price")->get();
        } else {
            // if keyword is present, list all by keyword order by price asc
            $data = Properties::where("name", "like", "%" . $request->keyword . "%")
                    ->orWhere("location", "like", "%" . $request->keyword . "%")
                    ->orWhere("city", "like", "%" . $request->keyword . "%")
                    ->orWhere("price", "like", "%" . $request->keyword . "%")
                    ->orderBy("price")->get();
        }

        $result = Array(
                    'success' => TRUE,
                    'message' => 'Property fetched',
                    'data' => PropertyResource::collection($data)
                );

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Properties::find($id);

        if (is_null($property)) {
            return response()->json('Data not found', 404);
        }

        $result = Array(
            'success' => TRUE,
            'message' => 'Property found',
            'data' => new PropertyResource($property)
        );

        return response()->json($result);
    }
}
