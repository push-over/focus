<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => 'PHP',
                'description' => 'PHP 是世界上最好的语言',
            ],
            [
                'name'        => 'JavaScript',
                'description' => '学好JS吃好不用愁',
            ],
            [
                'name'        => 'Vue',
                'description' => '快读搭建前端页面',
            ],
            [
                'name'        => 'Mysql',
                'description' => '数据库优化很重要',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
