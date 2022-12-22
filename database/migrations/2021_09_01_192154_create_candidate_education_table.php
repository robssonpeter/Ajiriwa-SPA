<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('degree_level_id')->nullable();
            $table->string('degree_title')->nullable();
            $table->string('country_id', 5)->nullable();
            $table->string('institute');
            $table->string('result')->nullable();
            $table->integer('year')->nullable();
            $table->integer('start_year');
            $table->boolean('currently_studying')->default(false);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('candidate_education');
    }
}
