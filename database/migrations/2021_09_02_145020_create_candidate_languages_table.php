<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('candidate_languages')){
            Schema::create('candidate_languages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('candidate_id', false);
                $table->integer('listening', false);
                $table->integer('speaking', false);
                $table->integer('reading', false);
                $table->integer('writing', false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_languages');
    }
}
