<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //index() 方法是加上索引，为 MySQL 下的搜索优化
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment('名称');  //comment() 方法能为表结构注释
            $table->text('description')->nullable()->comment('描述');
            $table->integer('post_count')->default(0)->comment('帖子数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
