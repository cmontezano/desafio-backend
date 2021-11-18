<?php

namespace App\Gateway;

use App\Exceptions\TransactionNotAuthorized;
use Illuminate\Support\Facades\Http;

class NotificationServiceGateway
{
    protected $url = 'http://o4d9z.mocklab.io/notify';
    private $client;

    /**
     * @throws TransactionNotAuthorized
     */
    public function __construct()
    {
        $this->client = Http::baseUrl($this->url);
    }

    public function healthCheck()
    {
        // se falso salvar numa fila
        return $this->client->get('/')->ok();
    }
}
