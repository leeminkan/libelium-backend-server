<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Sensor extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'key' => $this->key,
            'unit' => $this->unit,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }
}
