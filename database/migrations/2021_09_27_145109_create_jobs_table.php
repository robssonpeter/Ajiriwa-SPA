<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('jobs')){
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('location')->nullable();
                $table->string('application_email')->nullable();
                $table->text('application_url')->nullable();
                $table->text('description');
                $table->string('reports_to')->nullable();
                $table->integer('job_type', false);
                $table->date('deadline');
                $table->boolean('cover_letter')->default(false);
                $table->string('slug');
                $table->string('apply_method');
                $table->string('email_subject')->nullable();
                $table->unsignedInteger('company_id');
                $table->integer('number_of_posts')->default(1);
                $table->integer('counted_views', false)->default(0);
                $table->integer('status')->default(1);
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
        Schema::dropIfExists('jobs');
    }
}
