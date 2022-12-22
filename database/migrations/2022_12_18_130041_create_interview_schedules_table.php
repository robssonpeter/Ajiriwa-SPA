<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id', false);
            $table->date('date');
            $table->time('time');
            $table->integer('interview_type');
            $table->integer('set_by', false);
            $table->boolean('done')->default(false);
            $table->text('venue')->nullable();
            $table->boolean('notified')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_schedules');
    }
}
