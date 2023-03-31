<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjiriwaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('ajiriwa_transactions'))
            Schema::create('ajiriwa_transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->char('type')->comment("+ or -");
                $table->string('description')->nullable();
                $table->unsignedInteger('plan_id');
                $table->float('amount');
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
        Schema::dropIfExists('ajiriwa_transactions');
    }
}
