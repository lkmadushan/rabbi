<?php

namespace App\UseCases;

use App\Models\Quote;
use App\Models\UsedQuote;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindDailyQuoteUseCase
{
    protected Carbon $date;
    protected Quote $dailyQuote;

    public function execute(Carbon $date): Quote
    {
        $this->date = $date;

        try {
            $this->dailyQuote = $this->findScheduledOrUsedQuote();
        } catch (ModelNotFoundException $e) {
            $this->dailyQuote = $this->findNewQuote();

            $this->markQuoteAsUsed();
        }

        return $this->dailyQuote;
    }

    /**
     * @throws ModelNotFoundException
     */
    protected function findScheduledOrUsedQuote(): Quote
    {
        /** @var Quote $quote */
        $quote = Quote::query()
            ->whereDate('scheduled_at', $this->date)
            ->orWhereIn(
                'id',
                UsedQuote::query()
                    ->select('quote_id')
                    ->whereDate('used_at', $this->date)
            )
            ->firstOrFail();

        return $quote;
    }

    protected function findNewQuote(): Quote
    {
        /** @var Quote $quote */
        $quote = Quote::query()
            ->whereNotIn(
                'id',
                UsedQuote::query()
                    ->select('quote_id')
                    ->whereYear('used_at', $this->date)
            )
            ->whereNotIn(
                'topic',
                Quote::query()
                    ->select('topic')
                    ->whereIn(
                        'id',
                        UsedQuote::query()
                            ->select('quote_id')
                            ->whereDate('used_at', $this->date->clone()->subDay())
                    )
            )
            ->first();

        return $quote;
    }

    protected function markQuoteAsUsed(): void
    {
        UsedQuote::query()->insert([
            'quote_id' => $this->dailyQuote->getKey(),
            'used_at' => $this->date->toDateTimeString(),
        ]);
    }
}
