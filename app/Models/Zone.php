<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function wateringEvents()
    {
        return $this->hasMany(WateringEvent::class);
    }
}
