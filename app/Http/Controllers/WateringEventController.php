<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\WateringEvent;
use Illuminate\Http\Request;
use App\Http\Resources\WateringEventResource;

class WateringEventController extends Controller
{
    public function start($zoneId)
    {
        try{
            $zone = Zone::where('id', $zoneId)->first();
            if(!$zone){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone ID!'
                ]);
            }else{
                $event = $zone->wateringEvents()->create(['status' => 'watering']);
                return response()->json([
                    'status_code' => 201,
                    'message' => 'Success!',
                    'data' => new WateringEventResource($event)
                ]);
            }
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function stop($zoneId)
    {
        try{
            $zone = Zone::where('id', $zoneId)->first();

            if(!$zone){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone ID!'
                ]);
            }else{
                $event = $zone->wateringEvents()->create(['status' => 'stopped']);
                return response()->json([
                    'status_code' => 201,
                    'message' => 'Success!'
                ]);
            }
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function status($zoneId)
    {
        try{
            $zone = Zone::where('id',$zoneId)->first();
            if(!$zone){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone ID!'
                ]);
            }else{
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Success!',
                    'data' => new WateringEventResource($zone->wateringEvents()->latest()->first())
                ]);
            }
            
        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}

