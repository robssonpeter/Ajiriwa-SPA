<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('skill_levels')){
            Schema::create('skill_levels', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('level', false);
                $table->timestamps();
            });
            $levels = [
                ['name' => 'Novice', 'level' => 1],
                ['name' => 'Intermediate', 'level' => 2],
                ['name' => 'Proficient', 'level' => 3],
                ['name' => 'Expert', 'level' => 4],
            ];
            \App\Models\SkillLevel::insert($levels);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_levels');
    }
}
