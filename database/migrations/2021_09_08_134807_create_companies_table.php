<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('companies')){
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('industry_id')->nullable();
                $table->string('name')->nullable();
                $table->string('website')->nullable();
                $table->string('location')->nullable();
                $table->string('primary_email')->nullable();
                $table->text('description')->nullable();
                $table->string('tin_number')->nullable();
                $table->string('logo')->nullable();
                $table->double('ajiriwa_balance')->nullable();
                $table->integer('hires_per_year', false)->nullable();
                $table->integer('source', false)->comment('how the user heard about us')->nullable();
                $table->integer('type', false)->nullable();
                $table->integer('original_user', false)->nullable();
                $table->integer('page_views', false)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
