<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->string('slug')->unique();
            $table->string('title');

            $table->text('excerpt')->nullable(); // выдержка из статьи (фрагмент)

            $table->text('content_raw'); // в формате .md, затем будет автоматически преобразован в HTML
            $table->text('content_html'); // отсюда читаем готовый HTML для вывода на странице

            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('blog_categories');

            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
