<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\UseCases\RegisterUserUseCase;
use App\Exceptions\RegisterUserException;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
    public function when_push_notification_key_already_exists(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        try {
            app(RegisterUserUseCase::class)->execute($user->onesignal_id);
        } catch (RegisterUserException $e) {
            $this->assertEquals("User already exists", $e->getMessage());
        }
    }
}
