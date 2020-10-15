<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCollection extends Model
{
    protected $table = 'data_collections';
    protected $fillable = [
        'waspmote_id',
        'transaction_id',
        'type',
        'value'
    ];

    public $filterRelationAttributes = [
        'name' => 'device.name',
    ];

    public $sortRelationAttributes = [
        'name' => 'device.name',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'waspmote_id', 'waspmote_id');
    }
}
