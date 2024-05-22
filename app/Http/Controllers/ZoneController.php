<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Resources\ZoneResource;
use Throwable;

class ZoneController extends Controller
{
    public function index()
    {
        try{
            $zones = Zone::all();
            return response()->json([
                'status_code' => 200,
                'message' => 'Success!',
                'data' => ZoneResource::collection($zones)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try{
            $getZoneById = Zone::find($id);

            if($getZoneById){
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Success!',
                    'data' => new ZoneResource($getZoneById)
                ]);

            }else{
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Not Found!',
                ]);;
            }
        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

    }

    public function store(Request $request)
    {
        try{
            $validatedData = $this->validate($request, $this->fields());
    
            $createdZone = Zone::create($validatedData);
            return response()->json([
                'status_code' => 201,
                'message' => 'Success!',
                'data' => new ZoneResource($createdZone)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validatedData = $this->validate($request, $this->fields());

            $getZoneById = Zone::find($id);

            if($getZoneById){
                $getZoneById->update($validatedData);
                return response()->json([
                    'status_code' => 201,
                    'message' => 'Success!',
                    'data' => new ZoneResource($getZoneById)
                ]);
            }else{
                return response()->json([
                    'status_code' => 404,
                    'message' => 'The given ID not found!'
                ]);
            }
            
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try{
            $getZoneById = Zone::find($id);

            if($getZoneById){
                $getZoneById->delete();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Zone deleted successfully!'
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'The given ID is not found!'
                ]);
            }
            
        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function fields()
    {
        return [
            'name' => 'required|string',
            'area' => 'required|string',
        ];
    }
}
