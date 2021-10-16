<?php

use App\Models\CertificateCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('certificate_categories')){
            Schema::create('certificate_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
            $initialCategories = [
                'Bachelor Degree', 'Post-graduate Degree', 'Other'
            ];

            foreach($initialCategories as $category){
                CertificateCategory::create(['name' => $category]);
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
        Schema::dropIfExists('certificate_categories');
    }
}
