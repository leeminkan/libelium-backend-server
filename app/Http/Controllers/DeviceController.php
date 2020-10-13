<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\Device as DeviceResource;
use App\Resources\DataCollection;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class DeviceController extends BaseController
{
    /**
     * @var DeviceRepository
     */
    private $device;

    /**
     * DeviceController constructor.
     * @param DeviceRepository $device
     */
    public function __construct(DeviceRepository $device)
    {
        $this->device = $device;
    }

    /**
     * Response list of all device
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->device->all();
            
            return $this->responseWithData(DeviceResource::collection($data));
        }, $request);
    }

    public function getData(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            
            $rules = [
                'type' => 'required',
            ];

            $messages = [
                'type.required' => 'type_required',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            $type = $request->get('type', '');
            $device = $this->device->findOrFail($id);
            $query = $device->data_collections()->where('type', $type);

            if (is_null($request->get('pagination')) || $request->get('pagination')) {
                $data = $query->paginate((int)$request->get('per_page', 10));
            } else {
                $data = $query->get();
            }

            
            return $this->responseWithData($data);
        }, $request);
    }
}
