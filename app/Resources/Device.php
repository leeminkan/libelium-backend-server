<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Enums\DataTypeEnum;

class Device extends Resource
{
    public function toArray($request)
    {
        $battery = $this->data_collections()->where('type', DataTypeEnum::Battery)
        ->orderBy('created_at', 'DESC')->first();

        return [
            'id' => $this->id,
            'waspmote_id' => $this->waspmote_id,
            'name' => $this->name,
            'battery' => $battery ? $battery->value : null,
            'created_at' => $this->created_at
        ];
    }
}
