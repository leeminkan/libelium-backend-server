<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AlgorithmParameter extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'waspmote_id' => $this->waspmote_id,
            'window_size' => $this->window_size,
            'saving_level' => $this->saving_level,
            'time_base' => $this->time_base,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
