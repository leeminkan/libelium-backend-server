<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
        ];
    }
}
