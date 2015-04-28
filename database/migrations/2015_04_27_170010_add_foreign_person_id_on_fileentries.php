<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignPersonIdOnFileentries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('fileentries', function(Blueprint $table)
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
        Schema::table('fileentries', function(Blueprint $table)
        {
            $table->dropForeign('fileentries_person_id_foreign');
        });
	}

}
