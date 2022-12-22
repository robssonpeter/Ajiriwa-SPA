<?php

use App\Models\InterviewType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('interview_types')){
            Schema::create('interview_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
        $defaultTypes = [
            'Face to Face', 'Telephone', 'Virtual'
        ];
        foreach($defaultTypes as $type){
            InterviewType::updateOrCreate(['name'=>$type], ['name'=>$type]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_types');
    }
}
