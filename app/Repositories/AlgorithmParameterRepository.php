<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AlgorithmParameterRepository as AlgorithmParameterRepositoryInterface;
use App\Models\AlgorithmParameter;
use DB;

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
    
    public function getAll() {
        $query = $this->allWithBuilder()
        ->join(
            DB::raw('(SELECT waspmote_id, MAX(created_at) created_at FROM algorithm_parameters WHERE is_selected = 1 GROUP BY waspmote_id) AS filter_table')
            , function($join)
            {
                $join->on('algorithm_parameters.waspmote_id', '=', 'filter_table.waspmote_id');
                $join->on('algorithm_parameters.created_at', '=', 'filter_table.created_at');
            }
        );

        return $query->get();
    }
}
