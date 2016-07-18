<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('settings') )
        {
            Schema::create('settings', function($table)
            {
                $table->engine = 'InnoDB';

                $table->increments('id')->index();
                $table->string('key', 255)->unique();
                $table->string('module', 255);
                $table->string('type', 255);
                $table->text('value');
                $table->text('option')->nullable();
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
        Schema::drop('settings');
    }

}