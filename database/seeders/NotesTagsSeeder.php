<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Notes;
use \App\Models\Tags;
use \App\Models\NotesTags;

class NotesTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notes = Notes::all();
        $tags = Tags::all();
        for ($i = 0; $i < count($notes); $i++) {
            for ($j = 0; $j < rand(1, count($tags)); $j++) {
                NotesTags::create([
                    'fk_notes_id' => $notes[$i]['id'],
                    'fk_tags_id' => $notes[rand(0, count($tags)-1)]['id']
                ]);
            }
        }
    }
}
