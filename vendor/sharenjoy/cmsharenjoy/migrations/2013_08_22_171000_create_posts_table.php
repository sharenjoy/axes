<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('posts') )
        {
            Schema::create('posts', function($table)
            {
                $table->engine = 'InnoDB';

                $table->increments('id')->index();
                $table->integer('user_id')->unsigned()->nullable()->default(0);
                $table->integer('status_id')->unsigned()->nullable()->default(0);
                $table->integer('album_id')->unsigned()->nullable()->default(0);
                $table->string('title', 255);
                $table->string('slug', 255)->unique();
                $table->text('content')->nullable();
                $table->integer('sort')->unsigned()->nullable()->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }

}