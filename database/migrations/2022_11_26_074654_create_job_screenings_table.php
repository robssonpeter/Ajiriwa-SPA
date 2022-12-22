<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_screenings', function (Blueprint $table) {
            $table->id();
            $table->text('question')->comment('question that will be used for screening');
            $table->text('answer')->comment('suitable answer for the question');
            $table->string('type', 100)->comment('answer type eg experience');
            $table->string('necessity', 50)->comment('if required or preferred');
            $table->string('job_id')->comment('the id of the job for which screening will be done');
            $table->string('name', 60)->comment('name of the variable for the question');
            $table->string('question_type', 60)->nullable();
            $table->text('options')->nullable();
            $table->text('input_type')->nullable();
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
        Schema::dropIfExists('job_screenings');
    }
}
