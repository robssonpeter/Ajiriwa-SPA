<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('professional_title')->after('address')->nullable();
            $table->string('phone')->after('address')->nullable();
            $table->integer('marital_status', false)->after('address')->nullable();
            $table->integer('profile_completion', false)->after('address')->nullable();
            $table->integer('gender', false)->after('address')->nullable();
            $table->date('dob')->after('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['professional_title', 'marital_status', 'profile_completion', 'gender', 'dob', 'phone']);
        });
    }
}
