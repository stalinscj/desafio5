<?php

namespace Tests\Feature\Auth\LoginController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_login()
    {
        $user = User::factory()->create();

        $attributes = [
            'email'    => $user->email,
            'password' => 'password'
        ];

        $this->get(route('login'))
            ->assertSuccessful()
            ->assertViewIs('auth.login');

        $this->post(route('login'), $attributes)
            ->assertRedirect(route('tasks.index'));

        $this->assertAuthenticated()
            ->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function users_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $attributes = [
            'email'    => $user->email,
            'password' => 'invalid'
        ];

        $this->post(route('login'), $attributes)
            ->assertSessionHasErrors('email')
            ->assertRedirect('/');

        $this->assertFalse(Auth::check());
    }
}
