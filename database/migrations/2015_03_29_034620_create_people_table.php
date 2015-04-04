<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table)
		{
			$table->string('first_name');
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->date('birthdate')->nullable();
			$table->integer('dni')->nullable()->unsigned();
			$table->enum('gender',['male','female']);
			$table->string('address')->nullable();
			$table->string('other')->nullable();
			$table->increments('id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('people');
	}

}
