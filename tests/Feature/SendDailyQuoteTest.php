<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use App\Models\SentQuote;
use Illuminate\Support\Facades\Date;
use Berkayk\OneSignal\OneSignalClient;
use App\UseCases\SendDailyQuoteUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendDailyQuoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_subscribed_users_exists(): void
    {
        $users = User::factory(10)->create();
        $quote = Quote::factory()->create();
        $this->mock(OneSignalClient::class)
            ->shouldReceive('sendNotificationToUser')
            ->times(10);

        app(SendDailyQuoteUseCase::class)->execute(
            Date::now()
        );

        foreach ($users as $user) {
            /** @var SentQuote $sent */
            $sent = SentQuote::query()->where('user_id', $user->getKey())->first();

            $this->assertEquals($sent->user_id, $user->getKey());
            $this->assertEquals($sent->quote_id, $quote->getKey());
            $this->assertNotNull($sent->sent_at);
        }
        $this->assertEquals(10, SentQuote::query()->count());
    }

    /** @test */
    public function only_send_quote_for_not_sent_users()
    {
        Quote::factory()->create();
        User::factory(10)->create();
        $this->mock(OneSignalClient::class)
            ->shouldReceive('sendNotificationToUser')
            ->times(12);

        app(SendDailyQuoteUseCase::class)->execute(
            $date = Date::now()
        );

        User::factory(2)->create();
        app(SendDailyQuoteUseCase::class)->execute($date);

        $this->assertEquals(12, SentQuote::query()->count());
    }
}
