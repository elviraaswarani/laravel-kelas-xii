<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_redirects_to_the_admin_dashboard(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Film terbaru');
    }

    public function test_regular_users_cannot_open_the_admin_dashboard(): void
    {
        $this->post(route('register'), [
            'name' => 'Ayu Pratama',
            'email' => 'ayu@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_dashboard_shows_recent_films_and_their_genres(): void
    {
        $admin = $this->createAdmin();
        $genre = Genre::create(['name' => 'Drama']);
        Film::create([
            'title' => 'Film Contoh',
            'sinopsis' => 'Sinopsis film contoh.',
            'year' => 2025,
            'poster' => 'm1.jpg',
            'genre_id' => $genre->id,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Film Contoh')
            ->assertSee('Drama');
    }

    public function test_guests_are_sent_to_the_login_form_for_the_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('auth_form', 'login');
    }

    private function createAdmin(): User
    {
        $profile = Profile::create(['umur' => 30, 'bio' => 'Admin', 'alamat' => 'Jakarta']);
        $role = Role::create(['name' => 'admin']);

        return User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password123',
            'profile_id' => $profile->id,
            'role_id' => $role->id,
        ]);
    }
}