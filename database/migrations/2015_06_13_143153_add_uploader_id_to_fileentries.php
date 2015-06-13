<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploaderIdToFileentries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('fileentries', function(Blueprint $table)
        {
            $table->integer('uploader_id')->unsigned();
            $table->foreign('uploader_id')->references('id')->on('users');
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
            $table->dropForeign('fileentries_uploader_id_foreign');
            $table->dropColumn('uploader_id');
        });
	}

}
