<?php

namespace App\UseCases;

use App\Models\SentQuote;
use App\Models\User;
use App\Exceptions\RegisterUserException;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($user) {
            $quote = $this->findDailyQuoteUseCase->execute($date = Date::now());

            $this->sendQuoteUseCase->execute($user, $quote);

            $user->save();

            SentQuote::query()->insert([
                'user_id' => $user->getKey(),
                'quote_id' => $quote->getKey(),
                'sent_at' => $date->toDateTimeString(),
            ]);
        });

        return $user;
    }
}
