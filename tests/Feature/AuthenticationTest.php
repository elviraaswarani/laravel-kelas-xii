<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_register_and_the_password_is_hashed(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Ayu Pratama',
            'email' => 'ayu@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'ayu@example.test')->firstOrFail();

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertDatabaseHas('profiles', ['id' => $user->profile_id]);
        $this->assertDatabaseHas('roles', ['id' => $user->role_id, 'name' => 'user']);
    }

    public function test_a_registered_user_can_log_in_and_log_out(): void
    {
        $this->post(route('register'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->get(route('home'))
            ->assertSee('Logout')
            ->assertDontSee('Login / Register');

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
        $this->get(route('home'))
            ->assertSee('Login / Register')
            ->assertDontSee('Logout');

        $response = $this->post(route('login'), [
            'email' => 'budi@example.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    public function test_registration_rejects_duplicate_email_and_mismatched_passwords(): void
    {
        $this->post(route('register'), [
            'name' => 'Citra Dewi',
            'email' => 'citra@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response = $this->from(route('home'))->post(route('register'), [
            'name' => 'Citra Lain',
            'email' => 'citra@example.test',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertDatabaseCount('users', 1);
    }
}