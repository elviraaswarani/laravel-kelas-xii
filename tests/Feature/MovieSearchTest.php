<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_movies_can_be_searched_by_title(): void
    {
        $genre = Genre::create(['name' => 'Drama']);
        Film::create([
            'title' => 'Finding Nemo',
            'sinopsis' => 'An animated adventure.',
            'year' => 2003,
            'poster' => 'm1.jpg',
            'genre_id' => $genre->id,
        ]);
        Film::create([
            'title' => 'The Matrix',
            'sinopsis' => 'A science fiction film.',
            'year' => 1999,
            'poster' => 'm2.jpg',
            'genre_id' => $genre->id,
        ]);

        $this->get(route('movies', ['search' => 'nemo']))
            ->assertOk()
            ->assertSee('Finding Nemo')
            ->assertDontSee('The Matrix');
    }

    public function test_search_shows_an_empty_state_when_no_movie_matches(): void
    {
        $this->get(route('movies', ['search' => 'no-such-film']))
            ->assertOk()
            ->assertSeeText('No movies found for "no-such-film".');
    }
}