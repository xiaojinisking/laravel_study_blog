<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     * @table posts
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug', 45)->comment('将文章标题转化为URL的一部分，以利于SEO');
            $table->string('title', 45)->comment('文章标题');
            $table->text('content')->nullable()->comment('文章内容');
            $table->timestamps();
            $table->timestamp('published_at')->index();

            $table->unique(["slug"], 'unique_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('posts');
     }
}
