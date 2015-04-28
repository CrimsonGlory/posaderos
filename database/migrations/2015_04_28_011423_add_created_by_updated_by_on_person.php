<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByUpdatedByOnPerson extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('people', function(Blueprint $table)
		{
			$table->integer('created_by')->unsigned();
			$table->integer('updated_by')->unsigned();
			$table->foreign('created_by')->references('id')
                         ->on('users');
			$table->foreign('updated_by')->references('id')
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
		Schema::table('people', function(Blueprint $table)
		{
			$table->dropForeign('people_updated_by_foreign');
			$table->dropForeign('people_created_by_foreign');
			$table->dropColumn('updated_by');
			$table->dropColumn('created_by');
			
		});
	}

}
