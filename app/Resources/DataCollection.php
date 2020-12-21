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
            'value' => $this->value,
            'for_algorithm' => $this->for_algorithm,
            'time_get_sample' => $this->time_get_sample,
            'algorithm_parameter_id' => $this->algorithm_parameter_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
