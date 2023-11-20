<?php

namespace App\UseCases;

use App\Models\User;
use App\Models\Quote;
use Berkayk\OneSignal\OneSignalClient;

class SendQuoteUseCase
{
    public function __construct(
        protected OneSignalClient $onesignal,
    ) {
    }

    public function execute(User $receiver, Quote $quote): void
    {
        $this->onesignal->sendNotificationToUser(
            $quote->content,
            $receiver->onesignal_id,
            null,
            null,
            null,
            null,
            $quote->topic
        );
    }
}
