<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';
    protected $fillable = [
        'name'
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_sensors');
    }
}
