<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlgorithmParameter extends Model
{
    protected $table = 'algorithm_parameters';
    protected $fillable = [
        'waspmote_id',
        'sensor_key',
        'window_size',
        'saving_level',
        'time_base'
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
