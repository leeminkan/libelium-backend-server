<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'waspmote_id',
        'type'
    ];
    
    public function data_collections()
    {
        return $this->hasMany(DataCollection::class, 'transaction_id', 'id');
    }
}
