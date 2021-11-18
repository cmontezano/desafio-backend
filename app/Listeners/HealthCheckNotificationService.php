<?php

namespace App\Listeners;

use App\Gateway\NotificationServiceGateway;

class HealthCheckNotificationService
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $event
     * @return bool
     */
    public function handle($event)
    {
        return (new NotificationServiceGateway())->healthCheck();
    }
}
