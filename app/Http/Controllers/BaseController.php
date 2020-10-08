<?php

namespace App\Http\Controllers;

use Exception;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseController extends Controller
{
    const DEFAULT_HTTP_CODE = 400;
    const DEFAULT_ERROR_CODE = 9999;

    /**
     * Convert message to json response format
     * @param $message
     * @return JsonResponse
     */
    public function messageResponse($message)
    {
        return $this->responseWithData([
            ['code' => 200, 'message' => $message]
        ]);
    }

    /**
     * @param null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseWithData($data = null, $statusCode = 200)
    {
        return response()->json([
            'error' => false,
            'data' => $data,
            'errors' => null
        ], $statusCode);
    }

    /**
     * @param $errors array
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse($errors, $statusCode = 400)
    {
        return response()->json([
            'error' => true,
            'data' => null,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * @param $validator Validator
     * @param int $statusCode
     * @return JsonResponse
     */
    public function validationErrorResponse($validator, $statusCode = 422)
    {
        return $this->errorResponse(
            $this->formatValidatorErrors($validator),
            $statusCode
        );
    }

    /**
     * @param Exception $exception
     * @return JsonResponse
     */
    public function exceptionErrorResponse($exception)
    {
        $code = self::DEFAULT_ERROR_CODE;
        $msg = $exception->getMessage();

        $httpCode = method_exists($exception, 'getHttpStatusCode')
            ? $exception->getHttpStatusCode()
            : self::DEFAULT_HTTP_CODE;

        return $this->errorResponse([
            [
                'code' => $code,
                'message' => $msg,
                'errorType' => method_exists($exception, 'getErrorType')
                    ? $exception->getErrorType()
                    : null,
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'staceTrack' => $exception->getTraceAsString()
            ]
        ], $httpCode);
    }

    /**
     * @param $validator Validator
     * @return array
     */
    protected function formatValidatorErrors($validator)
    {
        $results = [];
        foreach ($validator->errors()->all() as $error) {
            $results[] = __("validation.$error");
        }
        return $results;
    }

    /**
     * @param $callback
     * @param Request|null $request
     * @return JsonResponse
     */
    protected function withErrorHandling($callback, $request = null)
    {
        try {
            return call_user_func($callback, $request ?: request());
        } catch (ModelNotFoundException $e) {
            return $this->exceptionErrorResponse($e);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->getValidator());
        } catch (Exception $e) {
            if (!$e->getMessage()) {
                jsonDump([
                    $e->getFile(),
                    $e->getLine()
                ]);
            }
            return $this->exceptionErrorResponse($e);
        }
    }

}
