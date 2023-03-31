<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("payer_name")->nullable();
            $table->unsignedInteger("user_id", false);
            $table->string("reference_number");
            $table->string("description")->nullable();
            $table->double("amount");
            $table->string("tracking_id")->nullable();
            $table->string("status")->default('initiated')->comment('initiated, FAILED, COMPLETED');
            $table->boolean('executed')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
