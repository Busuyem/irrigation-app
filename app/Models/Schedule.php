<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
