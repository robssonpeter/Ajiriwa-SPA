<?php

use App\Models\EducationLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('education_levels')){
            Schema::create('education_levels', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
            $levels = ['Primary', 'Secondary', 'High School', 'Undergraduate', 'Graduate', 'Post-Graduate'];

            foreach($levels as $level){
                EducationLevel::create(['name' => $level]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education_levels');
    }
}
