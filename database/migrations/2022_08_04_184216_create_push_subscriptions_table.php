<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('webpush.database_connection'))->create(config('webpush.table_name'), function (Blueprint $table) {
            $table->charset ='utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->integer('guest_id')->unsigned()->index();
            $table->morphs('subscribable');
            $table->string('endpoint', 500)->unique();
            $table->string('public_key')->nullable();
            $table->string('auth_token')->nullable();
            $table->string('content_encoding')->nullable();
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
        Schema::connection(config('webpush.database_connection'))->dropIfExists(config('webpush.table_name'));
    }
}
