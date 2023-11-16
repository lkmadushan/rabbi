<?php

namespace App\UseCases;

use Exception;
use App\Models\User;
use App\Models\Quote;
use App\Models\SentQuote;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Collection;

class SendDailyQuoteUseCase
{
    protected Carbon $date;
    protected Quote $dailyQuote;

    public function __construct(
        protected Repository $config,
        protected OneSignalClient $onesignal,
        protected FindDailyQuoteUseCase $findDailyQuoteUseCase,
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

            $records = [];

            foreach ($users as $user) {
                $this->onesignal->sendNotificationToUser(
                    $this->dailyQuote->content,
                    $user->onesignal_id,
                    null,
                    null,
                    null,
                    null,
                    $this->dailyQuote->topic
                );

                $records[] = [
                    'user_id' => $user->getKey(),
                    'quote_id' => $this->dailyQuote->getKey(),
                    'sent_at' => $this->date->toDateTimeString(),
                ];
            }

            SentQuote::query()->insert($records);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            report($e);
        }
    }
}
