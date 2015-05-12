<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToPeople extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('people', function(Blueprint $table)
		{
			$table->integer('avatar')->nullable()->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('people', function(Blueprint $table)
		{
                        $table->dropColumn('avatar');
		});
	}

}
