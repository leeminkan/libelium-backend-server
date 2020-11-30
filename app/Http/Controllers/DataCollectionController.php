<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\DataCollectionRepository;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\DataCollection as DataCollection;

class DataCollectionController extends BaseController
{
    /**
     * @var DataCollectionRepository
     */
    private $data_collections;

    /**
     * @var DeviceRepository
     */
    private $device;

    /**
     * DataCollectionController constructor.
     * @param DataCollectionRepository $data_collections
     * @param DeviceRepository $device
     */
    public function __construct(DataCollectionRepository $data_collections, DeviceRepository $device)
    {
        $this->data_collections = $data_collections;
        $this->device = $device;
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

    public function seedForWaspmoteId(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use($id) {
            $device = $this->device->findOrFail($id);
            if ($device) {
                for ($x = 0; $x <= 10; $x++) {

                    $this->data_collections->create([
                        'waspmote_id' => $device->waspmote_id,
                        'type' => 'battery',
                        'value' => rand(10,100)
                    ]);
                    $this->data_collections->create([
                        'waspmote_id' => $device->waspmote_id,
                        'type' => 'temperature',
                        'value' => rand(10,40)
                    ]);
                }
            }
            return $this->responseWithData("Seed Successfully!!");
        }, $request);
    }
}
