<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Enums\SensorKeyEnum;
use App\Resources\Sensor;

class Device extends Resource
{
    public function toArray($request)
    {
        $battery = $this->data_collections()->where('sensor_key', SensorKeyEnum::Pin)
        ->orderBy('created_at', 'DESC')->first();

        return [
            'id' => $this->id,
            'waspmote_id' => $this->waspmote_id,
            'name' => $this->name,
            'image' => $this->image,
            'is_displayed' => $this->is_displayed,
            'battery' => $battery ? $battery->value : null,
            'sensors' => Sensor::collection($this->sensors()->get()),
            'created_at' => $this->created_at
        ];
    }
}
