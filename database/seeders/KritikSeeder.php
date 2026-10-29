<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\{Film, Kritik, User};
use Faker\Factory as Faker;

class KritikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Kritik::create(1000)->create();

        $faker = Faker::create('id_ID');
        $filmIds = Film::query()->pluck('id')->all();
        $userIds = User::query()->pluck('id')->all();

        for($loop = 1; $loop <= 1000; $loop++)
        {
            Kritik::create([
                'comment'   => $faker->text($maxNbChars = 200),
                'rating'    => $faker->numberBetween(1,5),
                'film_id'   => $faker->randomElement($filmIds),
                'user_id'   => $faker->randomElement($userIds),
            ]);
        }
    }
}
