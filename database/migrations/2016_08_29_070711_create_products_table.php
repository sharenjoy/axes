<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('category_id')->unsigned()->index();
            $table->integer('album_id')->unsigned()->index();
            $table->integer('filealbum_id')->unsigned()->index();
            $table->integer('status_id')->unsigned()->default(1);
            if (config('cmsharenjoy.language_default')) $table->char('language', 4)->nullable()->index();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('video')->nullable();
            $table->string('img');
            $table->text('specification')->nullable();
            $table->text('pnb_key_serialize');
            $table->text('pnb_value_serialize');
            $table->text('pnb_price_serialize');
            $table->text('price_range_start_serialize');
            $table->text('price_range_end_serialize');
            $table->text('price_discount_serialize');
            $table->integer('sort')->unsigned()->default(0);
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
        Schema::drop('products');
    }
}
