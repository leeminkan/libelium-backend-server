<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Setting extends Resource
{
    public function toArray($request)
    {

        return [
            'window_size' => $this->window_size,
            'saving_level' => $this->saving_level,
            'time_base' => $this->time_base,
            'comparition_page' => $this->comparition_page,
            'algorithm_param_page' => $this->algorithm_param_page
        ];
    }
}
