<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\ErrorRateRepository;
use App\Resources\ErrorRate as ErrorRateResource;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class ErrorRateController extends BaseController
{
    /**
     * @var ErrorRateRepository
     */
    private $error_rate;

    /**
     * ErrorRateController constructor.
     * @param ErrorRateRepository $error_rate
     */
    public function __construct(ErrorRateRepository $error_rate)
    {
        $this->error_rate = $error_rate;
    }

    /**
     * Response list of all ErrorRate
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            return ErrorRateResource::collection(
                $this->error_rate->serverFilteringFor($request)
            )->additional([
                'error' => false,
                'errors' => null
            ]);
        }, $request);
    }

    public function store(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->error_rate->create($request->all());
            
            return $this->responseWithData(new ErrorRateResource($data));
        }, $request);
    }

    public function find($id)
    {
        return $this->withErrorHandling(function () use ($id) {
            $data = $this->error_rate->findOrFail($id);
            return $this->responseWithData(new ErrorRateResource($data));
        });
    }

    public function update(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $error_rate = $this->error_rate->findOrFail($id);
            $this->error_rate->update($error_rate, $request->all());
            return $this->responseWithData(new ErrorRateResource($error_rate->fresh()));
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $error_rate = $this->error_rate->findOrFail($id);
            $this->error_rate->destroy($error_rate);
            return $this->messageResponse("Successfully!");
        }, $request);
    }

    public function delete(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            $this->error_rate->advancedDelete($request);
            return $this->responseWithData("Successfully!!");
        }, $request);
    }
}
