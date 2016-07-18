<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function($table)
		{
			$table->engine = 'InnoDB';

		    $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0);
		    $table->string('type', 100)->index();
		    $table->string('title', 255);
		    $table->string('slug', 255)->unique();
		    $table->text('description');
		    $table->integer('weight')->index();
            $table->integer('sort')->unsigned()->nullable()->default(0);
		    $table->timestamps();
		    $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories');
	}

}