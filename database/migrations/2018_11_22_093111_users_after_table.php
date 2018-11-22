<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAfterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('notification_count')->default(0)->comment('消息');
            $table->unsignedInteger('topic_count')->default(0)->comment('发布数量');
            $table->unsignedInteger('love')->default(200)->comment('飞吻');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('notification_count');
            $table->dropColumn('topic_count');
            $table->dropColumn('love');
        });
    }
}
