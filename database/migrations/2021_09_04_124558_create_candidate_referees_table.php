<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('candidate_referees')){
            Schema::create('candidate_referees', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('position')->nullable();
                $table->string('company');
                $table->string('email')->nullable();
                $table->string('phone');
                $table->text('postal_address');
                $table->integer('candidate_id');
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
        Schema::dropIfExists('candidate_referees');
    }
}
