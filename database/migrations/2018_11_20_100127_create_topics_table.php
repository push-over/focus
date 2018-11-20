<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->text('body')->comment('内容');
            $table->unsignedInteger('user_id')->comment('用户');
            $table->unsignedInteger('category_id')->nullable()->comment('所属分类');
            $table->unsignedInteger('reward')->nullable()->comment('悬赏');
            $table->unsignedInteger('reply_count')->default(0)->comment('回复数量');
            $table->unsignedInteger('view_count')->default(0)->comment('浏览量');
            $table->unsignedInteger('last_reply_user_id')->default(0)->comment('最后回复的用户');
            $table->unsignedInteger('order')->default(0)->comment('排序');
            $table->boolean('adopt')->default(false)->comment('是否已采纳');
            $table->text('excerpt')->nullable()->comment('SEO优化');
            $table->string('slug')->nullable()->comment('SEO优化url');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
