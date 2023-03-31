<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionAndKeywordsColumnsToJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_categories', function (Blueprint $table) {
            if(!Schema::hasColumn('job_categories', 'description')){
                $table->text('description')->nullable();
            }
            if(!Schema::hasColumn('job_categories', 'keywords')){
                $table->text('keywords')->nullable();
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
        Schema::table('job_categories', function (Blueprint $table) {
            $table->dropColumn(['description', 'keywords']);
        });
    }
}
