<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\SensorRepository;
use App\Resources\Sensor as SensorResource;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class SensorController extends BaseController
{
    /**
     * @var SensorRepository
     */
    private $sensor;

    /**
     * SensorController constructor.
     * @param SensorRepository $sensor
     */
    public function __construct(SensorRepository $sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Response list of all sensor
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            return SensorResource::collection(
                $this->sensor->serverFilteringFor($request)
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        }, $request);
    }

    public function store(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->sensor->create($request->all());
            
            return $this->responseWithData(new SensorResource($data));
        }, $request);
    }

    public function find($id)
    {
        return $this->withErrorHandling(function () use ($id) {
            $data = $this->sensor->findOrFail($id);
            return $this->responseWithData(new SensorResource($data));
        });
    }

    public function update(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $sensor = $this->sensor->findOrFail($id);
            $this->sensor->update($sensor, $request->all());
            return $this->responseWithData(new SensorResource($sensor->fresh()));
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $sensor = $this->sensor->findOrFail($id);
            $this->sensor->destroy($sensor);
            return $this->messageResponse("Successfully!");
        }, $request);
    }
}
