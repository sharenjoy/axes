<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
		    $table->string('name')->after('password');
		    $table->string('phone')->after('name');
		    $table->string('avatar')->after('phone');
		    $table->text('description')->after('avatar');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('name');
		    $table->dropColumn('phone');
		    $table->dropColumn('avatar');
		    $table->dropColumn('description');
		});
	}

}
