<?php

use App\Custom\DataTransfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('candidates', 'slug'))
            Schema::table('candidates', function (Blueprint $table) {
                $table->string('slug')->nullable();
            });
            DataTransfer::fixCandidateSlug();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
