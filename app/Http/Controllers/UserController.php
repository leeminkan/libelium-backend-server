<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\UserRepository;
use App\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            $data = $this->user->all();
            
            return $this->responseWithData(UserResource::collection($data));
        }, $request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->withErrorHandling(function ($request) use ($id) {
            $user = $this->user->findOrFail($id);
            $this->user->destroy($user);
            return $this->messageResponse("Successfully!");
        }, $request);
    }
    
    public function login(Request $request)
    {
        return $this->withErrorHandling(function ($request) {
            
            $rules = [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ];

            $messages = [
                'email.required' => 'email_required',
                'email.string' => 'email_string',
                'email.email' => 'email_invalid',
                'password.required' => 'password_required',
                'password.string' => 'password_string',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                throw (new ValidationException)->setValidator($validator);
            }

            $credentials = request(['email', 'password']);

            if(!Auth::attempt($credentials)) {
                return $this->errorResponse([__('validation.unauthorized')], 401);
            }

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');

            return $this->responseWithData([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }, $request);
    }
}
