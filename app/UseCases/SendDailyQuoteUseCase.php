<?php

namespace App\UseCases;

use App\Models\User;
use App\Models\Quote;
use App\Models\SentQuote;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SendDailyQuoteUseCase
{
    protected Carbon $date;
    protected Quote $dailyQuote;

    public function __construct(
        protected OneSignalClient $onesignal,
        protected FindDailyQuoteUseCase $findDailyQuoteUseCase
    ) {
    }

    public function execute(Carbon $date): void
    {
        $this->date = $date;
        $this->dailyQuote = $this->findDailyQuoteUseCase->execute($date);

        $this->queryUsersRemainingToSend()
            ->chunk(
                1000,
                fn (Collection $users) => $this->send($users)
            );
    }

    public function queryUsersRemainingToSend(): Builder
    {
        return User::query()
            ->whereNotIn(
                'id',
                SentQuote::query()
                    ->select('user_id')
                    ->where('quote_id', $this->dailyQuote->getKey())
            );
    }

    public function send(Collection $users): void
    {
        try {
            DB::beginTransaction();

            $records = $users->map(fn (User $user) => [
                'user_id' => $user->getKey(),
                'quote_id' => $this->dailyQuote->getKey(),
                'sent_at' => $this->date->toDateTimeString(),
            ]);

            SentQuote::query()->insert($records->toArray());

            $this->onesignal->sendNotificationToAll(
                $this->dailyQuote->topic,
                env('APP_URL'),
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
