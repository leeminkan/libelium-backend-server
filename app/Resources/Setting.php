<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Enums\DataTypeEnum;

class Setting extends Resource
{
    public function toArray($request)
    {

        return [
            'window_size' => $this->window_size,
            'saving_level' => $this->saving_level,
            'time_base' => $this->time_base
        ];
    }
}
