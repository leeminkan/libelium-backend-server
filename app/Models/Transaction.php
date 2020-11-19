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

    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->data_collections()->delete();
        }

        return parent::delete();
    }
    
    public function data_collections()
    {
        return $this->hasMany(DataCollection::class, 'transaction_id', 'id');
    }
}
