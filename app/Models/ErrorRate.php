<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorRate extends Model
{
    protected $table = 'error_rates';
    protected $fillable = [
        'waspmote_algorithm',
        'waspmote_not_algorithm',
        'sensor_key',
        'value',
        'created_at',
        'updated_at'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_key', 'key');
    }
}
