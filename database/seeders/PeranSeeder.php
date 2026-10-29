<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\{Cast, Film, Peran};
use Faker\Factory as Faker;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        $filmIds = Film::query()->pluck('id')->all();
        $castIds = Cast::query()->pluck('id')->all();

        for($loop = 1; $loop <= 300; $loop++)
        {
            Peran::create([
                "film_id"    => $faker->randomElement($filmIds),
                "cast_id"    => $faker->randomElement($castIds),
                "actor"      => $faker->jobTitle,
            ]);
        }
    }
}
