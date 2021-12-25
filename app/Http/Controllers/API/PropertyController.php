<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Properties;
use App\Http\Resources\PropertyResource;

class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get owner_id
        $owner_id = auth('sanctum')->user()->id;

        // list all by owner
        $data = Properties::where('owner_id', $owner_id)->latest()->get();

        $result = Array(
            'success' => TRUE,
            'message' => 'Property fetched',
            'data' => PropertyResource::collection($data)
        );

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get owner_id
        $owner_id = auth('sanctum')->user()->id;

        $validator = Validator::make($request->all(),[
            'name'          => 'required|string|max:255',
            'description'   => 'required',
            'location'      => 'required|string',
            'city'          => 'required|string',
            'price'         => 'required|numeric',
            'amenities'     => 'string',
        ]);

        if($validator->fails()){
            $result = Array(
                'success' => FALSE,
                'message' => 'Error',
                'data' => $validator->errors()
            );
            return response()->json($result);
        }

        $property = Properties::create([
            'owner_id'      => $owner_id,
            'name'          => $request->name,
            'description'   => $request->description,
            'location'      => $request->location,
            'city'          => $request->city,
            'price'         => $request->price,
            'amenities'     => $request->amenities,
        ]);

        $result = Array(
            'success' => TRUE,
            'message' => 'Property created successfully',
            'data' => new PropertyResource($property)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Properties $properties, $id)
    {
        // get owner_id
        $owner_id = auth('sanctum')->user()->id;

        $validator = Validator::make($request->all(),[
            'name'          => 'required|string|max:255',
            'description'   => 'required',
            'location'      => 'required|string',
            'city'          => 'required|string',
            'price'         => 'required|numeric',
            'amenities'     => 'string',
        ]);

        if($validator->fails()){
            $result = Array(
                'success' => FALSE,
                'message' => 'Error',
                'data' => $validator->errors()
            );
            return response()->json($result);
        }

        $properties = Properties::find($id);
        $properties->owner_id   = $owner_id;
        $properties->name       = $request->name;
        $properties->description= $request->description;
        $properties->location   = $request->location;
        $properties->city       = $request->city;
        $properties->price      = $request->price;
        $properties->amenities  = $request->amenities;
        $properties->save();

        $result = Array(
            'success' => TRUE,
            'message' => 'Property updated successfully',
            'data' => new PropertyResource($properties)
        );

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Properties $properties, $id)
    {
        $properties = Properties::find($id);

        $properties->delete();

        $result = Array(
            'success' => TRUE,
            'message' => 'Property deleted successfully',
        );

        return response()->json($result);
    }

}
