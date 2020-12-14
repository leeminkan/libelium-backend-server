<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';
    protected $fillable = [
        'name',
        'key'
    ];

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->algorithm_parameters()->delete();
            $this->devices()->sync([]);
        }

        return parent::delete();
    }
    
    public function algorithm_parameters()
    {
        return $this->hasMany(AlgorithmParameter::class, 'sensor_key', 'key');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_sensors');
    }
}
