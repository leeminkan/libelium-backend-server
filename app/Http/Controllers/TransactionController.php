<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Interfaces\TransactionRepository;
use App\Resources\Transaction as TransactionTemperature;

class TransactionController extends BaseController
{
    /**
     * @var TransactionRepository
     */
    private $transaction;

    /**
     * TransactionController constructor.
     * @param TransactionRepository $transaction
     */
    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Response list of all transaction
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->withErrorHandling(function ($request) {

            $data = $this->transaction->all();
            
            return $this->responseWithData(TransactionTemperature::collection($data));
        }, $request);
    }
}
