<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsColumnToFrequentlyAskedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frequently_asked_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('frequently_asked_questions', 'views')){
                $table->unsignedInteger('views', false)->default(0);
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
        Schema::table('frequently_asked_questions', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
}
