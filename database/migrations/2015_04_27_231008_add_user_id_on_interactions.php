<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdOnInteractions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interactions', function(Blueprint $table)
		{
		$table->integer('user_id')->unsigned();
            	$table->foreign('user_id')->references('id')
               		 ->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('interactions', function(Blueprint $table)
		{
			$table->dropForeign('interactions_user_id_foreign');
		});
	}

}
