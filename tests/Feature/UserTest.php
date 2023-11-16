<?php

namespace Tests\Feature;

use App\Exceptions\RegisterUserException;
use App\UseCases\RegisterUserUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_empty_push_notification_key_provided(): void
    {
        try {
            app(RegisterUserUseCase::class)->execute('');
        } catch (RegisterUserException $e) {
            $this->assertEquals("No push notification key provided", $e->getMessage());
        }
    }

    /** @test */
    public function when_push_notification_key_provided(): void
    {
        app(RegisterUserUseCase::class)->execute($key = '12345');

        $this->assertDatabaseHas('users', ['onesignal_id' => $key]);
    }

}
