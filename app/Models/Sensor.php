<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sensor_id',
        'location',
        'status',
        'baseline_aqi',
        'frequency',
        'variation',
        'latitude',
        'longitude',
        'simulated_aqi',
        'current_aqi',
        'last_updated'
    ];

}
