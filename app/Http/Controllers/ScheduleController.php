<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotification;
use Illuminate\Support\Carbon;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    public function index($zoneId)
    {
        try{
            $zone = Zone::find($zoneId);

            if(!$zone){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone ID'
                ]);
            }else{
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Success!',
                    'data' => ScheduleResource::collection($zone->schedules)
                ]);
            }
            

        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($zoneId, $scheduleId)
    {
        try{
            $zone = Zone::where('id', $zoneId)->first();
            $schedule = $zone->schedules()->find($scheduleId);
            if(!$schedule){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid schedule ID'
                ]);
            }else{
                return response()->json([
                    'status_code' => '200',
                    'message' => 'Success!',
                    'data' => new ScheduleResource($schedule)
                ]);
            }
        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request, $zoneId)
    {
        try{
            $validatedData = $request->validate($this->fields());

            $validatedData['start_time'] = Carbon::createFromFormat('g:ia', $validatedData['start_time'])->format('H:i:s'); 
    
            $zone = Zone::findOrFail($zoneId);

            if(!$zone){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone ID!'
                ]);
            }else{
            
                $schedule = $zone->schedules()->create($validatedData);
    
                // Send notification email
                //Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule));
        
                return response()->json([
                    'status_code' => 201,
                    'message' => 'Success!',
                    'data' => new ScheduleResource($schedule)
                ]);
            }

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $zoneId, $scheduleId)
    {
        try{
            $validatedData = $request->validate($this->fields());

            $validatedData['start_time'] = Carbon::createFromFormat('g:ia', $validatedData['start_time'])->format('H:i:s'); 

            $zone = Zone::findOrFail($zoneId);
            $schedule = $zone->schedules()->findOrFail($scheduleId);
            if(!$schedule){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid schedule ID!'
                ]);
            }else{
                $schedule->update($validatedData);
                //Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule));
                return response()->json([
                    'status_code' => '200',
                    'message' => 'Success!',
                    'data' => new ScheduleResource($schedule)
                ]);
            }

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($zoneId, $scheduleId)
    {
        try{
            $zone = Zone::where('id', $zoneId)->first();
            $getZoneScheduleById = $zone->schedules()->where('id',$scheduleId)->first();
            if(!$getZoneScheduleById){
                return response()->json([
                    'status_code' => 404,
                    'message' => 'Invalid zone schedule ID'
                ]);
            }else{
                $getZoneScheduleById->delete();
                return response()->json([
                    'status_code' => '200',
                    'message' => 'Schedule removed successfully!'
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
            'start_time' => 'required|string',
            'duration' => 'required|integer',
            'days_of_week' => 'required|array',
        ];
    }
}

