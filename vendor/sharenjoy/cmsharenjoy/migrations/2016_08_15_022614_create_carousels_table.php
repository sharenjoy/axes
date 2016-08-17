<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousels', function($table) {
            $table->increments('id')->index();
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->integer('status_id')->unsigned()->nullable()->default(0);
            $table->string('title');
            $table->string('img')->nullable();
            $table->string('video')->nullable();
            $table->string('link')->nullable();
            $table->enum('type', ['image', 'video']);
            $table->text('content')->nullable();
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
        Schema::drop('carousels');
    }
}
