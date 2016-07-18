<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('tag', 255)->index();
			$table->boolean('suggest')->default(false);
			$table->integer('count')->unsigned()->default(1); // count of how many times this tag was used
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
		Schema::drop('tags');
	}

}
