<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\AlgorithmParameterRepository;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\AlgorithmParameter as AlgorithmParameter;
use App\Events\MqttPushlisher;


class AlgorithmParameterController extends BaseController
{
    /**
     * @var AlgorithmParameterRepository
     */
    private $algorithmParameter;

    /**
     * @var DeviceRepository
     */
    private $device;

    /**
     * AlgorithmParameterController constructor.
     * @param AlgorithmParameterRepository $algorithmParameter
     * @param DeviceRepository $device
     */
    public function __construct(AlgorithmParameterRepository $algorithmParameter, DeviceRepository $device)
    {
        $this->algorithmParameter = $algorithmParameter;
        $this->device = $device;
    }

    /**
     * Response list of all algorithm parameter
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            return AlgorithmParameter::collection(
                $this->algorithmParameter->serverFilteringFor($request)
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        }, $request);
    }

    public function store(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->algorithmParameter->create($request->all());
            
            event(new MqttPushlisher('notification', json_encode([
                "type" => "update-algorithm-parameter",
                "value" => $data
            ])));

            return $this->responseWithData(new AlgorithmParameter($data));
        }, $request);
    }

    public function getOne(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            $data = $this->algorithmParameter->allWithBuilder()
            ->where('waspmote_id', $request->get('waspmote_id', null))
            ->orderBy('created_at', 'DESC')
            ->first();
            return $this->responseWithData(new AlgorithmParameter($data));
        });
    }

    public function getAll(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            return AlgorithmParameter::collection(
                $this->algorithmParameter->getAll()
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        });
    }

    public function find($id)
    {
        return $this->withErrorHandling(function () use ($id) {
            $data = $this->algorithmParameter->findOrFail($id);
            return $this->responseWithData(new AlgorithmParameter($data));
        });
    }

    public function update(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $data = $this->algorithmParameter->findOrFail($id);
            $this->algorithmParameter->update($data, $request->all());
            return $this->responseWithData(new AlgorithmParameter($data->fresh()));
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $data = $this->algorithmParameter->findOrFail($id);
            $this->algorithmParameter->destroy($data);
            return $this->messageResponse("Successfully!");
        }, $request);
    }
}
