<?php

use App\Models\BlogPost;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugAndOldIdColumnToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('blog_posts', 'slug'))
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->string('slug')->nullable();
            });
        
        if(!Schema::hasColumn('blog_posts', 'old_id'))  
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->unsignedInteger('old_id', false)->nullable();
            });


        // fix existing blog post
        $posts = BlogPost::whereNull('slug')->get();
        foreach($posts as $post){
            $slug = makeSlug($post->Title, '-');
            BlogPost::where('id', $post->id)->update(['slug' => $slug]);
        }    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('slug', 'old_id');
        });
    }
}
