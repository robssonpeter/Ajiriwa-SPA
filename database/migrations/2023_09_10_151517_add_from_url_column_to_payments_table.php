<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromUrlColumnToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('payments', 'from_url')){
            Schema::table('payments', function (Blueprint $table) {
                $table->text('from_url')->nullable()->coment('a url from which the payment was initiated');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_column_to_payments', function (Blueprint $table) {
            $table->dropColumn('from_url');
        });
    }
}
