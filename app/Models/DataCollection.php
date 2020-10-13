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
}
