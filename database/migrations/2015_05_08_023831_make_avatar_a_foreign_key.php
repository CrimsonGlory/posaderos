<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAvatarAForeignKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('people', function(Blueprint $table)
		{
			$table->foreign('avatar')->references('id')
                                                     ->on('fileentries');
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
			$table->dropForeign('people_avatar_foreign');
		});
	}

}
