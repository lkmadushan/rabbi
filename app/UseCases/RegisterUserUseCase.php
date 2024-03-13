<?php

namespace App\UseCases;

use App\Models\User;
use App\Models\SentQuote;
use App\Exceptions\QuotesException;
use Illuminate\Support\Facades\Date;
use App\Exceptions\RegisterUserException;

class RegisterUserUseCase
{
    public function __construct(
        protected SendQuoteUseCase $sendQuoteUseCase,
        protected FindDailyQuoteUseCase $findDailyQuoteUseCase,
    ) {
    }

    /**
     * @throws RegisterUserException
     */
    public function execute($pushKey): User
    {
        if (empty($pushKey)) {
            throw RegisterUserException::noPushNotificationKeyProvided();
        }

        /** @var User $user */
        $user = User::query()->firstOrNew(['onesignal_id' => $pushKey]);

        if ($user->exists) {
            throw RegisterUserException::userAlreadyExists();
        }

        $user->save();

        try {
            $quote = $this->findDailyQuoteUseCase->execute($date = Date::now());

            $this->sendQuoteUseCase->execute($user, $quote);

            SentQuote::query()->insert([
                'user_id' => $user->getKey(),
                'quote_id' => $quote->getKey(),
                'sent_at' => $date->toDateTimeString(),
            ]);
        } catch (QuotesException $e) {
            //
        }

        return $user;
    }
}
