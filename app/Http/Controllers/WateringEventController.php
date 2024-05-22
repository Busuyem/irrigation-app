<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\WateringEvent;
use Illuminate\Http\Request;

class WateringEventController extends Controller
{
    public function start($zoneId)
    {
        $zone = Zone::findOrFail($zoneId);
        $event = $zone->wateringEvents()->create(['status' => 'watering']);

        return response()->json($event, 201);
    }

    public function stop($zoneId)
    {
        $zone = Zone::findOrFail($zoneId);
        $event = $zone->wateringEvents()->create(['status' => 'stopped']);

        return response()->json($event, 201);
    }

    public function status($zoneId)
    {
        $zone = Zone::findOrFail($zoneId);
        return response()->json($zone->wateringEvents()->latest()->first());
    }
}

