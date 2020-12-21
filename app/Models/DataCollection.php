<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCollection extends Model
{
    protected $table = 'data_collections';
    protected $fillable = [
        'waspmote_id',
        'sensor_key',
        'value',
        'for_algorithm',
        'time_get_sample',
        'algorithm_parameter_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'time_get_sample' => 'float',
    ];

    public $filterRelationAttributes = [
        'device_name' => 'device.name',
        'sensor_name' => 'sensor.name',
    ];

    public $sortRelationAttributes = [
        'device_name' => 'device.name',
        'sensor_name' => 'sensor.name',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'waspmote_id', 'waspmote_id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_key', 'key');
    }
}
