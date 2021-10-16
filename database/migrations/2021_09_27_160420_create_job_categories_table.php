<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\JobCategory;

class CreateJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $categories = [
            'Accountancy, Banking and Finance',
            'Business, Consulting and Management',
            'Charity and Voluntary Work',
            'Creative Arts and Design',
            'Energy and Utilities',
            'Engineering and Manufacturing',
            'Environment and Agriculture',
            'Healthcare',
            'Hospitality and Events Management',
            'Information Technology',
            'Law',
            'Leisure, Sport and Tourism',
            'Security',
            'Marketing',
            'Media and Internet',
            'Procurement',
            'Property and Construction',
            'Public Services and Administration',
            'Recruitment and HR',
            'Restaurant and Food Service',
            'Sales',
            'Science and Pharmaceuticals',
            'Social care',
            'Teacher Training and Education',
            'Telecommunication',
            'Transport and Logistics'
        ];

        foreach($categories as $category){
            JobCategory::create(['name' => $category]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_categories');
    }
}
