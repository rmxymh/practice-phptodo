<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('todos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('content');
			$table->string('comment')->nullable();
			$table->integer('user_id')->unsigned();
			$table->timestamps('updated_at');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::drop('todos');
    }
}
