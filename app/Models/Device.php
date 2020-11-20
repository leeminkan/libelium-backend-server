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
        'is_displayed'
    ];

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->sensors()->sync([]);
            $this->transactions()->delete();
        }

        return parent::delete();
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'waspmote_id', 'waspmote_id');
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
