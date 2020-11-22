<?php

namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Interfaces\DeviceRepository as DeviceRepositoryInterface;
use Illuminate\Support\Arr;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
    public function model()
    {
        return Device::class;
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
            'waspmote_id',
            'name',
            'is_displayed',
            'created_at',
            'updated_at'
        ];
    }

    public function create($data)
    {
        $device = parent::create(Arr::except($data, [
            'sensors'
        ]));

        if (isset($data['sensors'])) {
            $device->sensors()->sync($data['sensors']);
        }

        return $device;
    }

    public function update($model, $data)
    {
        parent::update($model, Arr::except($data, [
            'sensors'
        ]));

        $device = $model->fresh();

        if (isset($data['sensors'])) {
            $device->sensors()->sync($data['sensors']);
        }

        return $device;
    }
}
