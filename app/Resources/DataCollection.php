<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DataCollection extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'waspmote_id' => $this->waspmote_id,
            'transaction_id' => $this->transaction_id,
            'type' => $this->type,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
