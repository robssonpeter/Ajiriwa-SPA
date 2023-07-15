<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProfileClaimColumnToVerificationAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verification_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('verificatio_attempts', 'is_profile_claim')){
                $table->boolean('is_profile_claim')->nullable();
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
            $table->dropColumn('is_profile_claim');
        });
    }
}
