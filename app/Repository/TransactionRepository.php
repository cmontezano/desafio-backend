<?php

namespace App\Repository;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(
        protected Transaction $model,
    ) {}
}
