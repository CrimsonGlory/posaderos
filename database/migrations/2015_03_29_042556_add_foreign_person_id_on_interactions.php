<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignPersonIdOnInteractions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interactions', function(Blueprint $table)
		{
			$table->integer('person_id')->unsigned()->change();
			$table->foreign('person_id')->references('id')
										->on('people');
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
			$table->dropForeign('interactions_person_id_foreign');
			$table->dropColumn('person_id');
		});
	}

}
