<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFileentriesIntoManyToManyPolymorphic extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fileentrieables', function(Blueprint $table)
		{
			$table->integer('fileentrieable_id')->unsigned();
			$table->integer('fileentry_id')->unsigned();
			$table->string('fileentrieable_type');
			$table->foreign('fileentry_id')->references('id')
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
		Schema::drop('fileentrieables');
	}

}
