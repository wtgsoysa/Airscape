<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sensor;

class SensorDisplayController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all(); // Pull all sensors
        return view('pages.user.home', compact('sensors'));
    }
}
