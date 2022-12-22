<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('companies', 'slug')){
            Schema::table('companies', function (Blueprint $table) {
                $table->string('slug')->nullable();
            });
        }
        $companies = \App\Models\Company::whereNull('slug')->get();
        foreach($companies as $company){
            if($company->name){
                $company->update(['slug' => makeSlug($company->name)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
