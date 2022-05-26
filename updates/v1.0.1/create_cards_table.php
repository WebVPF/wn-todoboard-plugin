<?php namespace WebVPF\TodoBoard\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWebvpfTodoboardCards extends Migration
{
    public function up()
    {
        Schema::create('webvpf_todoboard_cards', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('desc')->nullable();
            $table->integer('count_comments')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('column_id')->unsigned();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webvpf_todoboard_cards');
    }
}
