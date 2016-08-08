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
		    $table->string('phone')->after('password');
		    $table->string('avatar')->after('phone');
		    $table->text('description')->after('avatar');
		    $table->boolean('activated')->default(0)->after('description');
			$table->string('activation_code')->nullable()->index()->after('activated');
			$table->timestamp('activated_at')->nullable()->after('activation_code');
			$table->timestamp('last_login')->nullable()->after('activated_at');
			$table->string('reset_password_code')->nullable()->index()->after('last_login');	
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
		    $table->dropColumn('phone');
		    $table->dropColumn('avatar');
		    $table->dropColumn('description');
		    $table->dropColumn('activated');
		    $table->dropColumn('activation_code');
		    $table->dropColumn('activated_at');
		    $table->dropColumn('last_login');
		    $table->dropColumn('reset_password_code');
		});
	}

}
