<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';
    protected $fillable = [
        'name'
    ];

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->devices()->sync([]);
        }

        return parent::delete();
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_sensors');
    }
}
