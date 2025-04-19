<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAlert extends Model
{
    // ✅ This must include BOTH fields
    protected $fillable = ['message', 'type'];
}
