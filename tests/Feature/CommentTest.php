<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Cast;
use App\Models\Genre;
use App\Models\Peran;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_is_sent_to_login_before_posting_a_comment(): void
    {
        $film = $this->createFilm();

        $this->get(route('movies.show', $film))
            ->assertSee('login atau daftar')
            ->assertDontSee(route('kritik.store'));

        $this->from(route('movies.show', $film))
            ->post(route('kritik.store'), [
                'film_id' => $film->id,
                'comment' => 'Komentar tamu',
                'rating' => 4,
            ])
            ->assertRedirect(route('login.form'));

        $this->get(route('login.form'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('auth_form', 'login');
        $this->assertDatabaseCount('kritiks', 0);
    }

    public function test_a_logged_in_user_can_comment_and_their_name_is_displayed(): void
    {
        $film = $this->createFilm();
        $user = $this->createUser();

        $this->actingAs($user)
            ->get(route('movies.show', $film))
            ->assertSee(route('kritik.store'))
            ->assertSee('comment-rating');

        $this->actingAs($user)
            ->post(route('kritik.store'), [
                'film_id' => $film->id,
                'comment' => 'Film yang sangat bagus.',
                'rating' => 5,
            ])
            ->assertRedirect(route('movies.show', $film));

        $this->assertDatabaseHas('kritiks', [
            'film_id' => $film->id,
            'user_id' => $user->id,
            'comment' => 'Film yang sangat bagus.',
            'rating' => 5,
        ]);

        $this->get(route('movies.show', $film))
            ->assertOk()
            ->assertSee('Film yang sangat bagus.')
            ->assertSee('Dewi Penonton');
    }

    public function test_movie_detail_displays_cast_name_instead_of_cast_id(): void
    {
        $film = $this->createFilm();
        $cast = Cast::create(['name' => 'Nadia Pemeran', 'age' => 28, 'bio' => 'Aktor film']);
        Peran::create([
            'film_id' => $film->id,
            'cast_id' => $cast->id,
            'actor' => 'Maya',
        ]);

        $this->get(route('movies.show', $film))
            ->assertOk()
            ->assertSee('Nadia Pemeran')
            ->assertDontSee('>' . $cast->id . '<');
    }

    private function createFilm(): Film
    {
        $genre = Genre::create(['name' => 'Drama']);

        return Film::create([
            'title' => 'Film Contoh',
            'sinopsis' => 'Sinopsis film contoh.',
            'year' => 2025,
            'poster' => 'm1.jpg',
            'genre_id' => $genre->id,
        ]);
    }

    private function createUser(): User
    {
        $profile = Profile::create(['umur' => 25, 'bio' => 'Penonton', 'alamat' => 'Bandung']);
        $role = Role::create(['name' => 'user']);

        return User::create([
            'name' => 'Dewi Penonton',
            'email' => 'dewi@example.test',
            'password' => 'password123',
            'profile_id' => $profile->id,
            'role_id' => $role->id,
        ]);
    }
}