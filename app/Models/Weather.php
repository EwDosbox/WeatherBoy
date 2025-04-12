<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'user_id',
        'temperature',
        'is_day',
        'wind_speed',
        'wind_direction',
        'weather_time',
    ];

    protected $casts = [
        'temperature' => 'float',
        'is_day' => 'boolean',
        'wind_speed' => 'float',
        'wind_direction' => 'float',
        'weather_time' => 'datetime',
    ];
    protected $table = 'weather';
    public $timestamps = false;
}
