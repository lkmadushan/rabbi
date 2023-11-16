<?php

namespace Tests\Feature;

use App\Exceptions\RegisterUserException;
use App\UseCases\RegisterUserUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function when_empty_user_id_sends_then_gives_error(): void
    {
        try {
            app(RegisterUserUseCase::class)->execute('');
        } catch (RegisterUserException $e) {
            $this->assertEquals("No user ID found", $e->getMessage());
        }
    }

    /** @test */
    public function when_user_id_sends_then_save_it_into_database(): void
    {
        $userId = "12345";
        app(RegisterUserUseCase::class)->execute($userId);

        $this->assertDatabaseHas(
            'users', [
            'onesignal_sub_id' => $userId,
        ]);
    }

}