<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\UserRepository;
use App\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * UserController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Response list of all user
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            
            $rules = [
                'name' => 'required'
            ];

            $messages = [
                'name.required' => 'name_required',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            $data = $this->user->all();
            
            return $this->responseWithData(UserResource::collection($data));
        }, $request);
    }
}
