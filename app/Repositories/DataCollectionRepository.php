<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DataCollectionRepository as DataCollectionRepositoryInterface;
use App\Models\DataCollection;
use Illuminate\Http\Request;

class DataCollectionRepository extends BaseRepository implements DataCollectionRepositoryInterface
{
    public function model()
    {
        return DataCollection::class;
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
            'device_name',
            'sensor_name',
            'created_at',
            'updated_at'
        ];
    }
    
    public function getByWaspmoteId(Request $request, $id){
        $query = $this->allWithBuilder()->where('waspmote_id',$id);
        $type = $request->get('type', null);

        if ($type) {
            $query->where('type', $type);
        }

        $this->filterQuery($query, $request->get('filters', []));
        $this->searchQuery($query, $request->get('search', null));
        $this->sortQuery($query, $request->get('order_by', null), $request->get('order', null));

        return $this->allOrPaginate($query, $request);
    }
}
