<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\DeviceRepository;
use App\Resources\Device as DeviceResource;
use App\Resources\DataCollection;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;

class DeviceController extends BaseController
{
    use UploadTrait;

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
            return DeviceResource::collection(
                $this->device->serverFilteringFor($request)
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
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ];

            $messages = [
                'image.image' => 'device_image_invalid',
                'image.mimes' => 'device_image_invalid',
                'image.max' => 'device_image_invalid',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            $input = $request->all();

            if ($request->has('image')) {
                // Get image file
                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'local', $name);

                $input['image'] = $filePath;
            }

            $data = $this->device->create($input);
            
            return $this->responseWithData(new DeviceResource($data));
        }, $request);
    }

    public function find($id)
    {
        return $this->withErrorHandling(function () use ($id) {
            $data = $this->device->findOrFail($id);
            return $this->responseWithData(new DeviceResource($data));
        });
    }

    public function update(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {

            $rules = [
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ];

            $messages = [
                'image.image' => 'device_image_invalid',
                'image.mimes' => 'device_image_invalid',
                'image.max' => 'device_image_invalid',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            $input = $request->all();

            if ($request->has('image')) {
                // Get image file
                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'local', $name);

                $input['image'] = $filePath;
            }

            $device = $this->device->findOrFail($id);
            $this->device->update($device, $input);
            return $this->responseWithData(new DeviceResource($device->fresh()));
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $device = $this->device->findOrFail($id);
            $this->device->destroy($device);
            return $this->messageResponse("Successfully!");
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
