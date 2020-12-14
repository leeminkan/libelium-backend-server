<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlgorithmParameterRepository as AlgorithmParameterRepositoryInterface;
use App\Models\AlgorithmParameter;
use Illuminate\Http\Request;

class AlgorithmParameterRepository extends BaseRepository implements AlgorithmParameterRepositoryInterface
{
    public function model()
    {
        return AlgorithmParameter::class;
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
            'created_at',
            'updated_at'
        ];
    }
}
