<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_tags', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('fk_notes_id');
            $table->unsignedBigInteger('fk_tags_id');
            $table->foreign('fk_notes_id')->references('id')->on('notes');
            $table->foreign('fk_tags_id')->references('id')->on('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes_tags');
    }
}
