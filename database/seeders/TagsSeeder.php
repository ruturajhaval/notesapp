<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Tags;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tags::truncate();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Tags::create([
                'uk_tagname' => $faker->word
            ]);
        }
    }
}
