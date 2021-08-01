<?php

namespace Tests\Feature\Auth\RegisterController;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Valid attributes to register an user
     *
     * @var array
     */
    protected $validAttributes;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->validAttributes = User::factory()
            ->unverified()
            ->raw([
                'remember_token'        => null,
                'password'              => 'password',
                'password_confirmation' => 'password',
            ]);
    }

    /**
     * @test
     */
    public function users_can_register()
    {
        $this->get(route('register'))
            ->assertSuccessful()
            ->assertViewIs('auth.register');

        $this->register($this->validAttributes)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('users', Arr::except($this->validAttributes, ['password', 'password_confirmation']));

        $this->assertTrue(Hash::check($this->validAttributes['password'], User::first()->password));
    }

    /**
     * @test
     */
    public function the_name_field_is_validated()
    {
        // The name is required
        $this->register($this->getValidAttributes(['name' => null]))
            ->assertSessionHasErrors('name');

        // The name must be a string
        $this->register($this->getValidAttributes(['name' => 123456]))
            ->assertSessionHasErrors('name');

        // The name may not be greater than 60 chars
        $this->register($this->getValidAttributes(['name' => Str::random(61)]))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('users', 0);
    }

    /**
     * @test
     */
    public function the_email_field_is_validated()
    {
        // The email is required
        $this->register($this->getValidAttributes(['email' => null])) 
            ->assertSessionHasErrors('email');

        // The email must be a string
        $this->register($this->getValidAttributes(['email' => 123456])) 
            ->assertSessionHasErrors('email');

        // The email may not be greater than 100 chars
        $this->register($this->getValidAttributes(['email' => Str::random(101)]))
            ->assertSessionHasErrors('email');

        // The email must be a valid email
        $this->register($this->getValidAttributes(['email' => 'invalid@email']))
            ->assertSessionHasErrors('email');

        // The email may not be 'email@hack.net'
        $this->register($this->getValidAttributes(['email' => 'email@hack.net']))
            ->assertSessionHasErrors('email');

        $user = User::factory()->create();
 
        // The email must be unique
        $this->register($this->getValidAttributes(['email' => $user->email]))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    /**
     * @test
     */
    public function the_password_field_is_validated()
    {
        // The password is required
        $this->register($this->getValidAttributes(['password' => null]))
            ->assertSessionHasErrors('password');

        // The password must be a string
        $this->register($this->getValidAttributes(['password' => 12345678]))
            ->assertSessionHasErrors('password');

        // The password must be at least 8 chars
        $this->register($this->getValidAttributes(['password' => Str::random(7)]))
            ->assertSessionHasErrors('password');

        // The password must be confirmed
        $this->register($this->getValidAttributes(['password_confirmation' => null]))
            ->assertSessionHasErrors('password');
    }

    /**
     * Make a request to register an User
     *
     * @param array $attributes
     * @return \Illuminate\Testing\TestResponse
     */
    protected function register($attributes)
    {
        return $this->post(route('register'), $attributes);
    }

    /**
     * Get valid attributes to register an user overwriting the fields given
     *
     * @param array $attributes
     * @return array
     */
    protected function getValidAttributes($attributes = [])
    {
        return array_merge($this->validAttributes, $attributes);
    }
}
