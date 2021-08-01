<?php

namespace Tests\Feature\Auth\LoginController;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_users_can_logout()
    {
        $this->signIn();

        $this->post(route('logout'));

        $this->assertFalse(Auth::check());
    }
}
