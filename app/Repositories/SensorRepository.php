<?php

namespace App\Repositories;

use App\Models\Sensor;
use App\Repositories\Interfaces\SensorRepository as SensorRepositoryInterface;

class SensorRepository extends BaseRepository implements SensorRepositoryInterface
{
    public function model()
    {
        return Sensor::class;
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
