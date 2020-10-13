<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\DataCollectionRepository;
use App\Resources\DataCollection as DataCollection;

class DataCollectionController extends BaseController
{
    /**
     * @var DataCollectionRepository
     */
    private $data_collections;

    /**
     * DataCollectionController constructor.
     * @param DataCollectionRepository $data_collections
     */
    public function __construct(DataCollectionRepository $data_collections)
    {
        $this->data_collections = $data_collections;
    }

    /**
     * Response list of all data collections
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            return DataCollection::collection(
                $this->data_collections->serverFilteringFor($request)
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        }, $request);
    }

    public function getByWaspmoteId(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use($id) {
            return DataCollection::collection(
                $this->data_collections->getByWaspmoteId($request, $id)
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        }, $request);
    }
}
