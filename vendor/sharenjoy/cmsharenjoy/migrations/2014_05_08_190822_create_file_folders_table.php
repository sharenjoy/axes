<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileFoldersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('file_folders', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->index();
            $table->integer('parent_id')->index()->unsigned()->nullable()->default(0);
            $table->string('slug', 100)->unique();
            $table->string('name', 100);
            $table->string('location', 20)->default('local');
            $table->string('remote_container', 100);
            $table->tinyInteger('hidden')->default(0);
            $table->integer('sort')->unsigned()->nullable()->default(0);
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
		Schema::drop('file_folders');
	}

}
