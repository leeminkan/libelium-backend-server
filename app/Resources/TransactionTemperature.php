<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TransactionTemperature extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'data_collections' => $this->data_collections ? DataCollection::collection($this->data_collections) : null,
        ];
    }
}
