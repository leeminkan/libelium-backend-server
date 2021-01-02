<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ErrorRate extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'waspmote_algorithm' => $this->waspmote_algorithm,
            'waspmote_not_algorithm' => $this->waspmote_not_algorithm,
            'sensor_key' => $this->sensor_key,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
