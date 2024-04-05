<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use App\Models\UsedQuote;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Testing\TestResponse;
use App\UseCases\FindDailyQuoteUseCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindDailyQuoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_multiple_scheduled_daily_quotes_exists_for_given_date_find_matching_for_date()
    {
        Quote::factory()->create(['scheduled_at' => Date::parse('2023-03-31')]);
        Quote::factory()->create(['scheduled_at' => $date = Date::parse('2023-04-01')]);
        Quote::factory()->create(['scheduled_at' => Date::parse('2023-04-02')]);

        $quote = app(FindDailyQuoteUseCase::class)->execute($date);

        $this->assertTrue($date->isSameDay($quote->scheduled_at));
    }

    /** @test */
    public function when_multiple_quotes_scheduled_for_given_date_returns_scheduled_first()
    {
        $quotes = Quote::factory(5)->create(['scheduled_at' => $date = Date::parse('2023-04-01')]);
        $quote = app(FindDailyQuoteUseCase::class)->execute($date);

        $this->assertTrue($quote->is($quotes->first()));
        $this->assertTrue($date->isSameDay($quote->scheduled_at));
    }

    /** @test */
    public function when_no_scheduled_quotes_for_given_date_returns_first_quote()
    {
        $quotes = Quote::factory(5)->create();

        $quote = app(FindDailyQuoteUseCase::class)->execute(Date::now());

        $this->assertTrue($quote->is($quotes->first()));
    }

    /** @test */
    public function when_no_scheduled_quotes_for_given_date_and_ask_multiple_times_returns_same_quote()
    {
        Quote::factory(5)->create();

        $quote1 = app(FindDailyQuoteUseCase::class)->execute(Date::now());
        $quote2 = app(FindDailyQuoteUseCase::class)->execute(Date::now());

        $this->assertNotNull($quote1);
        $this->assertTrue($quote1->is($quote2));
    }

    /** @test */
    public function when_exists_used_quote_for_given_date_and_ask_multiple_times_returns_same_quote()
    {
        $user = User::factory()->create();
        $quotes = Quote::factory(2)->create();

        UsedQuote::query()->forceCreate([
            'quote_id' => $quotes->first()->getKey(),
            'used_at' => $date = Date::now(),
        ]);
        $quote1 = app(FindDailyQuoteUseCase::class)->execute($date);
        $quote2 = app(FindDailyQuoteUseCase::class)->execute($date);

        $this->assertNotNull($quote1);
        $this->assertTrue($quote1->is($quote2));
    }

    /** @test */
    public function when_no_scheduled_quotes_for_given_date_returns_not_used_quote_within_year()
    {
        $quotes = Quote::factory(2)->create();

        UsedQuote::query()->forceCreate([
            'quote_id' => $quotes->first()->getKey(),
            'used_at' => Date::parse('2023-04-01'),
        ]);
        $quote = app(FindDailyQuoteUseCase::class)->execute(Date::parse('2023-04-10'));

        $this->assertTrue($quote->is($quotes->last()));
        $this->assertTrue($quote->isNot($quotes->first()));
    }

    /** @test */
    public function when_no_scheduled_quotes_for_given_date_returns_used_quote_from_last_year()
    {
        $quote = Quote::factory()->create();

        UsedQuote::query()->forceCreate([
            'quote_id' => $quote->getKey(),
            'used_at' => Date::parse('2022-03-31'),
        ]);
        $dailyQuote = app(FindDailyQuoteUseCase::class)->execute(Date::parse('2023-03-31'));

        $this->assertTrue($quote->is($dailyQuote));
    }

    /** @test */
    public function always_use_different_topic_to_the_previous_day()
    {
        $quotes = Quote::factory(2)->create([
            'topic' => 'Topic 1'
        ]);
        Quote::factory()->create([
            'topic' => 'Topic 2'
        ]);

        UsedQuote::query()->forceCreate([
            'quote_id' => $quotes->first()->getKey(),
            'used_at' => Date::parse('2023-03-31'),
        ]);
        $dailyQuote = app(FindDailyQuoteUseCase::class)->execute(Date::parse('2023-04-01'));

        $this->assertNotEquals('Topic 1', $dailyQuote->topic);
    }

    /** @test */
    public function when_request_next_quote()
    {
        Carbon::setTestNow('2023-11-17');
        Quote::factory(10)->create();

        Session::put('date', Carbon::parse('2023-11-07'));

        for ($i = 0; $i < 5; $i++) {
            $response = $this->getQuote('next');

            $this->assertNextQuoteReceived($response, Carbon::parse('2023-11-07')->addDays($i + 1));
        }
    }

    /** @test */
    public function when_request_previous_quote()
    {
        Quote::factory(10)->create();

        $this->get('/quote');

        for ($i = 0; $i < 5; $i++) {
            $response = $this->getQuote('previous');

            $this->assertPreviousQuoteReceived($response, Carbon::now()->subDays($i + 1));
        }
    }

    /** @test */
    public function when_no_scheduled_quote_for_given_date_and_no_used_quotes()
    {
        $response = $this->getQuote();

        $this->assertQuotesNotReceived($response, Carbon::now());
    }

    /** @test */
    public function when_get_quotes_for_future_date()
    {
        Session::put('date', Carbon::now());

        $response = $this->getQuote('next');

        $this->assertQuotesNotReceived($response, Carbon::now()->addDay());
    }

    protected function getQuote(string $page = null): TestResponse
    {
        $url = '/quote';

        if ($page) {
            $url .= '?page='.$page;
        }

        return $this->getJson($url);
    }

    protected function assertNextQuoteReceived(TestResponse $response, Carbon $expectedDate): void
    {
        $this->assertQuoteReceived($response, $expectedDate);
    }

    protected function assertPreviousQuoteReceived(TestResponse $response, Carbon $expectedDate): void
    {
        $this->assertQuoteReceived($response, $expectedDate);
    }

    protected function assertQuoteReceived(TestResponse $response, Carbon $expectedDate): void
    {
        $response->assertOk();

        $this->assertEquals($expectedDate->format('Y-m-d'), Session::get('date')->format('Y-m-d'));

        $response->assertJsonStructure([
            'date',
            'topic',
            'content',
            'source'
        ]);

        $this->assertNotNull($response->json('date'));
        $this->assertNotNull($response->json('topic'));
        $this->assertNotNull($response->json('content'));
        $this->assertNotNull($response->json('source'));
    }

    protected function assertQuotesNotReceived(TestResponse $response, Carbon $date): void
    {
        $response->assertOk();

        $response->assertJsonStructure([
            'date',
            'message'
        ]);

        $this->assertSame(
            'Quotes not found for '.$date->toDateString(),
            $response->json('message')
        );

        $this->assertSame(
            $date->toDateString(),
            Carbon::parse($response->json('date'))->toDateString()
        );
    }
}
