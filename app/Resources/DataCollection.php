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
            'device_name' => $this->device ? $this->device->name : null,
            'sensor_name' => $this->sensor ? $this->sensor->name : null,
            'transaction_id' => $this->transaction_id,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
