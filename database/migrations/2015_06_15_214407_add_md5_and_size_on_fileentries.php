<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMd5AndSizeOnFileentries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fileentries', function(Blueprint $table)
		{
			$table->integer('size')->unsigned();
			$table->char('md5',32);
			$table->index('size');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fileentries', function(Blueprint $table)
		{
			$table->dropColumn('size');
			$table->dropColumn('md5');
		});
	}

}
