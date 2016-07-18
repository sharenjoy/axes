<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taggables', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';

			$table->integer('tag_id')->index()->unsigned();
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

			$table->string('taggable_id', 36)->index();
			$table->string('taggable_type', 255)->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taggables');
	}

}
