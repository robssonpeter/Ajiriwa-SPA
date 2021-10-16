<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('candidate_certificates')){
            Schema::create('candidate_certificates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('institution')->nullable();
                $table->integer('candidate_id', false)->nullable();
                $table->integer('category', false)->nullable();
                $table->integer('media_id', false)->nullable();
                $table->integer('country_id', false)->nullable();
                $table->date('valid_until')->nullable();
                $table->date('completion_date')->nullable();
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
        Schema::dropIfExists('candidate_certificates');
    }
}
