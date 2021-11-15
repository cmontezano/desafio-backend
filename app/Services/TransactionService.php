<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repository\TransactionRepository;

class TransactionService
{
    public function __construct(
        private TransactionRepository $transactionRepository,
    ) {}

    public function make(int $payerId, int $payeeId, $amount): Transaction
    {
        $transaction = $this->transactionRepository->store([
            'payer_id' => $payerId,
            'payee_id' => $payeeId,
            'amount' => $amount,
        ]);

        $transaction->payer()->decrement('balance', $amount);
        $transaction->payee()->increment('balance', $amount);

        return $transaction;
    }
}
