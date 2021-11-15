<?php

namespace App\Http\Controllers;

use App\Exceptions\TransactionNotAuthorized;
use App\Gateway\TransactionAuth;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
    ) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        if ($request->get('payer_id') === $request->get('payee_id')) {
            return response(['error' => 'You cannot send money for yourself!'], 403);
        }

        try {
            DB::beginTransaction();

            App::make(TransactionAuth::class)->isAuthorized();

            $transaction = $this->transactionService->make(
                $request->get('payer_id'),
                $request->get('payee_id'),
                $request->get('amount')
            );

            DB::commit();

            return response(new TransactionResource($transaction), 201);
        } catch (TransactionNotAuthorized $e) {
            DB::rollBack();

            return response(['error' => 'Transaction not authorized'], 400);
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['error' => $e->getMessage()], 400);
        }
        // enviar notificação para o payee user que o mesmo recebeu uma transferência
    }
}
