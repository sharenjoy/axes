<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned()->index();
            $table->integer('folder_id')->index()->unsigned()->default(0);
		$table->foreign('folder_id')->references('id')->on('file_folders')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->default(1);
            $table->enum('type', array('a', 'v', 'd', 'i', 'o'))->nullable();
            $table->string('name', 255);
            $table->string('filename', 255);
            $table->string('path', 255);
            $table->text('description');
            $table->string('extension', 10);
            $table->string('mimetype', 100);
            $table->string('keywords', 32);
            $table->smallInteger('width')->unsigned()->nullable();
            $table->smallInteger('height')->unsigned()->nullable();
            $table->integer('filesize')->unsigned()->default(0);
            $table->string('alt_attribute', 255);
            $table->integer('download_count')->unsigned()->default(0);
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
		Schema::drop('files');
	}

}
