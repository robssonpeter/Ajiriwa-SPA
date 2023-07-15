<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnToVerificationAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verification_attempts', function (Blueprint $table) {
            if(!Schema::hasColumn('verification_attempts', 'user_id')){
                $table->unsignedInteger('user_id', false)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verification_attempts', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
