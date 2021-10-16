<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('job_applications')){
            Schema::create('job_applications', function (Blueprint $table) {
                $table->id();
                $table->integer('job_id', false);
                $table->integer('candidate_id', false);
                $table->text('cover_letter')->nullable();
                $table->integer('status', false)->default(1);
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
        Schema::dropIfExists('job_applications');
    }
}
