<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\SettingRepository;
use App\Resources\Setting as SettingResource;

class SettingController extends BaseController
{
    /**
     * @var SettingRepository
     */
    private $setting;

    /**
     * SettingController constructor.
     * @param SettingRepository $setting
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Response list of setting
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->setting->allWithBuilder()->first();
            
            return $this->responseWithData(new SettingResource($data));
        }, $request);
    }


    public function getComparisionPage(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->setting->allWithBuilder()->first();
            
            return $this->responseWithData($data->comparition_page);
        }, $request);
    }


    public function getAlgorithmParamPage(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->setting->allWithBuilder()->first();
            
            return $this->responseWithData($data->algorithm_param_page);
        }, $request);
    }

    /**
     * Response list of setting
     * @param Request $request
     * @return JsonResponse
     */

    public function update(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $model = $this->setting->allWithBuilder()->first();
            
            if (!$model) {
                $data = $this->setting->create($request->all());
            } else {
                $data = $this->setting->update($model, $request->all());
            }
            
            return $this->responseWithData(new SettingResource($data));
        }, $request);
    }
}
