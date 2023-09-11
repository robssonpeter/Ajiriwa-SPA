<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjiriwaBalanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajiriwa_balance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id', false);
            $table->string('description');
            $table->char('change_type')->default('+')->comment('+ or -');
            $table->double('amount', null, 2);
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
        Schema::dropIfExists('ajiriwa_balance_logs');
    }
}
