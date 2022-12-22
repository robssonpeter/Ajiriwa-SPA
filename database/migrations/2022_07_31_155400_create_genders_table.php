<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('genders')){
            Schema::create('genders', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
            $genders = [
                ['name' => 'Male'],
                ['name' => 'Female'],
            ];
            \App\Models\Gender::insert($genders);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
