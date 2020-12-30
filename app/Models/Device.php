<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $fillable = [
        'waspmote_id',
        'name',
        'image',
        'active',
        'description',
        'algorithm_param_description',
        'is_displayed'
    ];

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->algorithm_parameters()->delete();
            $this->sensors()->sync([]);
        }

        return parent::delete();
    }
    
    public function algorithm_parameters()
    {
        return $this->hasMany(AlgorithmParameter::class, 'waspmote_id', 'waspmote_id');
    }
    
    public function data_collections()
    {
        return $this->hasMany(DataCollection::class, 'waspmote_id', 'waspmote_id');
    }

    public function sensors()
    {
        return $this->belongsToMany(Sensor::class, 'device_sensors');
    }
}
