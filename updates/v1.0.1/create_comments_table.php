<?php namespace WebVPF\TodoBoard\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWebvpfTodoboardComments extends Migration
{
    public function up()
    {
        Schema::create('webvpf_todoboard_comments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('content')->nullable();
            // $table->text('content_html')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('edit_user_id')->nullable();
            $table->integer('delete_user_id')->nullable();
            $table->integer('card_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webvpf_todoboard_comments');
    }
}
