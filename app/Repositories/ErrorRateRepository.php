<?php

namespace App\Repositories;

use App\Models\ErrorRate;
use App\Repositories\Interfaces\ErrorRateRepository as ErrorRateRepositoryInterface;

class ErrorRateRepository extends BaseRepository implements ErrorRateRepositoryInterface
{
    public function model()
    {
        return ErrorRate::class;
    }

    public function searchFields(): array
    {
        return [
            'id',
            'created_at',
            'updated_at'
        ];
    }

    public function sortFields(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at'
        ];
    }
}
