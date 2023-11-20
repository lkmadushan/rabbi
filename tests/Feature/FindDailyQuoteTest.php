<?php

namespace Tests\Feature;

use App\Models\Quote;
use App\Models\UsedQuote;
use App\Models\User;
use App\UseCases\FindDailyQuoteUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

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
        User::factory()->create();
        Quote::factory(10)->create();

        $this->get('/quote');

        for ($i = 0; $i < 5; $i++) {
            $date =  Session::get('date', Carbon::now());
            $response = $this->get('/quote?page=next');
            $response->assertOk();
            $this->assertEquals($date->format('Y-m-d'), Session::get('date')->format('Y-m-d'));
        }
    }

    /** @test */
    public function when_request_previous_quote()
    {
        User::factory()->create();
        Quote::factory(10)->create();

        $this->get('/quote');

        for ($i = 0; $i < 5; $i++) {
            $date =  Session::get('date', Carbon::now());
            $response = $this->get('/quote?page=previous');
            $response->assertOk();
            $this->assertEquals($date->format('Y-m-d'), Session::get('date')->format('Y-m-d'));
        }
    }
}
