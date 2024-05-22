<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotification;

class ScheduleController extends Controller
{
    public function index($zoneId)
    {
        $zone = Zone::findOrFail($zoneId);
        return response()->json($zone->schedules);
    }

    public function show($zoneId, $scheduleId)
    {
        $zone = Zone::findOrFail($zoneId);
        $schedule = $zone->schedules()->findOrFail($scheduleId);
        return response()->json($schedule);
    }

    public function store(Request $request, $zoneId)
    {
        $validated = $request->validate([
            'start_time' => 'required|string',
            'duration' => 'required|integer',
            'days_of_week' => 'required|array',
        ]);

        $zone = Zone::findOrFail($zoneId);
        $schedule = $zone->schedules()->create($validated);

        // Send notification email
        Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule));

        return response()->json($schedule, 201);
    }

    public function update(Request $request, $zoneId, $scheduleId)
    {
        $validated = $request->validate([
            'start_time' => 'sometimes|string',
            'duration' => 'sometimes|integer',
            'days_of_week' => 'sometimes|array',
        ]);

        $zone = Zone::findOrFail($zoneId);
        $schedule = $zone->schedules()->findOrFail($scheduleId);
        $schedule->update($validated);

        // Send notification email
        Mail::to('admin@cashcardng.com')->send(new ScheduleNotification($schedule));

        return response()->json($schedule);
    }

    public function destroy($zoneId, $scheduleId)
    {
        $zone = Zone::findOrFail($zoneId);
        $zone->schedules()->findOrFail($scheduleId)->delete();

        return response()->noContent();
    }
}

