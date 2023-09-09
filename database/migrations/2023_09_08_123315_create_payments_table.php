<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id', false)->nullable();
            $table->string('reference_number', 30);
            $table->string('email', 100)->nullable();
            $table->string('transaction_type', 50)->default('Balance Recharge');
            $table->string('transaction_tracking_id', 100)->nullable();
            $table->text('description')->nullable();
            $table->String('status', 10)->default('Initiated')->comment('Initiated, FAILED, COMPLETED');
            $table->boolean('redeemed')->default(false);
            $table->string('currency', 5)->comment('currency code eg USD or TZS');
            $table->double('amount', null, 2);
            $table->boolean('attempted')->default(false)->comment('if true then the user attempted to pay');
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
        Schema::dropIfExists('payments');
    }
}
