<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Notes;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Notes::truncate();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Notes::create([
                'uk_title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
            ]);
        }
    }
}
