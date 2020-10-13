<?php

namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Interfaces\DeviceRepository as DeviceRepositoryInterface;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
    public function model()
    {
        return Device::class;
    }
}
