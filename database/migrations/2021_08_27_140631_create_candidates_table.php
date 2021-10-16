<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('candidates')){
            Schema::create('candidates', function (Blueprint $table) {
                $table->id();
                $table->string('first_name')->nullable();
                $table->string('middle_name')->nullable();
                $table->string('last_name')->nullable();
                $table->unsignedInteger('user_id', false);
                $table->string('nationality')->nullable();
                $table->integer('career_level_id', false)->nullable();
                $table->integer('industry_id', false)->nullable();
                $table->double('expected_salary')->nullable();
                $table->string('salary_currency')->nullable();
                $table->text('address')->nullable();
                $table->boolean('immediate_available')->default(1);

                /*$table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('industry_id')->references('id')->on('industries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                $table->foreign('marital_status_id')->references('id')->on('marital_status')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');*/

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
        Schema::dropIfExists('candidates');
    }
}
