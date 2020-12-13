<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\DataCollectionRepository;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\DataCollection as DataCollection;
use DB;
use App\Exports\DataCollectionsExport;
use App\Imports\DataCollectionsImport;
use Maatwebsite\Excel\Facades\Excel;


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

    public function seed(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            try {
                DB::beginTransaction();
                $data = $request->get('data', []);
                foreach ($data as $arrayValue) {
                    if (is_string($arrayValue)) {
                        $newArray = str_replace("'", "\"", $arrayValue);
                        $arrayValue =  (array) json_decode($newArray);
                    }
                    if (is_array($arrayValue)) {
                        $device = $this->device->allWithBuilder()->where('waspmote_id', $arrayValue["waspmote_id"])->first();
                        if (!$device) {
                            return $this->errorResponse([__('validation.device_not_found')], 404);
                        }
                        $this->data_collections->create($arrayValue);
                    }
                }
                DB::commit();
                return $this->responseWithData("Seed Successfully!!");
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }, $request);
    }

    public function export(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            $type = $request->get('type', 'csv');
            $data = $this->data_collections->serverFilteringFor($request);
            return Excel::download(new DataCollectionsExport($data),'data.'.$type);
        }, $request);
    }

    public function import(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            if ($request->has('file')) {
                $file = $request->file('file');
                Excel::import(new DataCollectionsImport, $file);
            }
            return $this->responseWithData("Import Successfully!!");
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $data = $this->data_collections->findOrFail($id);
            $this->data_collections->destroy($data);
            return $this->messageResponse("Successfully!");
        }, $request);
    }

    public function delete(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            $this->data_collections->advancedDelete($request);
            return $this->responseWithData("Successfully!!");
        }, $request);
    }
}
