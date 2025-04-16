<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertRule extends Model
{
    protected $fillable = [
        'pollutant_type',
        'threshold',
        'frequency',
        'email_alert',
        'system_alert',
    ];
}
