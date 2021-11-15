<?php

namespace App\Gateway;

use App\Exceptions\TransactionNotAuthorized;
use Illuminate\Support\Facades\Http;

class TransactionAuth
{
    protected $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    private $client;

    /**
     * @throws TransactionNotAuthorized
     */
    public function __construct()
    {
        $this->client = Http::baseUrl($this->url);
    }

    public function isAuthorized()
    {
        if (! $this->client->get()->ok()) {
            throw new TransactionNotAuthorized();
        }
    }
}
