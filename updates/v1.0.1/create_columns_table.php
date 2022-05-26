<?php namespace WebVPF\TodoBoard\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWebvpfTodoboardColumns extends Migration
{
    public function up()
    {
        Schema::create('webvpf_todoboard_columns', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('count_cards')->default(0);
            $table->integer('user_id')->unsigned()->index();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webvpf_todoboard_columns');
    }
}
