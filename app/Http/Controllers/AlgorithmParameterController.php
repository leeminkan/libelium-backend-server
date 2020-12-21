<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\AlgorithmParameterRepository;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\AlgorithmParameter as AlgorithmParameter;
use App\Events\MqttPushlisher;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;


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

            $rules = [
                'waspmote_id' => 'required',
                'window_size' => 'required',
                'saving_level' => 'required',
                'time_base' => 'required',
            ];

            $messages = [
                'waspmote_id.required' => 'device_image_invalid',
                'window_size.required' => 'device_image_invalid',
                'saving_level.required' => 'device_image_invalid',
                'time_base.required' => 'device_image_invalid',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            // disable hết
            $this->algorithmParameter->allWithBuilder()
            ->where('waspmote_id', $request->get('waspmote_id', null))
            ->update([
                'is_selected' => 0
            ]);

            // kiểm tra xem có cái nào tồn tại chưa ?
            $data = $this->algorithmParameter->allWithBuilder()
            ->where('waspmote_id', $request->get('waspmote_id', null))
            ->where('window_size', $request->get('window_size', null))
            ->where('saving_level', $request->get('saving_level', null))
            ->where('time_base', $request->get('time_base', null))
            ->first();

            // nếu có thì enable lại
            if ($data) {
                $this->algorithmParameter->update($data, [
                    'is_selected' => 1
                ]);
            } else {
                // chưa thì tạo mới với enable
                $data = $this->algorithmParameter->create(array_merge($request->all(), [
                    'is_selected' => 1
                ]));
            }
            
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
            ->where('is_selected', '1')
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

    public function delete(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            $this->algorithmParameter->advancedDelete($request);
            return $this->responseWithData("Successfully!!");
        }, $request);
    }
}
