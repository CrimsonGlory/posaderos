<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Person;
use App\Interaction;
use App\User;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('PeopleTableSeeder');
		$this->call('UserTableSeeder');
	}

}
class PeopleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('interactions')->delete();
		DB::table('people')->delete();
		DB::table('users')->delete();

		$person1=Person::create(['first_name'=>'Juan Román',
		 'last_name'=>'Riquelme',
			'address'=>'Callao 500', 'gender'=>'Male']);
		$person2=Person::create(['first_name'=>'Carlos',
		 'last_name'=>'Navarro Montoya',
			'address'=>'Callao 501', 'gender'=>'Male']);
		$person3=Person::create(['first_name'=>'Carlos',
		 'last_name'=>'Mac Allister',
			'address'=>'Callao 502', 'gender'=>'Male']);
		$person4=Person::create(['first_name'=>'Diego Armando',
		 'last_name'=>'Maradona',
			'address'=>'Callao 503', 'gender'=>'Male']);
		$person5=Person::create(['first_name'=>'Valeria',
		 'last_name'=>'Mazza',
			'address'=>'Callao 504', 'gender'=>'Female',
			'dni'=>123455,'other'=>'algun otro dato'
			]);
		$person6=Person::create(['first_name'=>'Ronaldinho',
		 'last_name'=>'Gaucho',
			'address'=>'Av. Brasil 789', 'gender'=>'Male',
			'dni'=>30100123,'other'=>'Futbolista'
			]);
		$person7=Person::create(['first_name'=>'Mark',
		 'last_name'=>'Zuckerberg',
			'address'=>'Silicon Valley 123', 'gender'=>'Male',
			'dni'=>30200123,'other'=>'Desarrollador'
			]);
		$person8=Person::create(['first_name'=>'Bill',
		 'last_name'=>'Gates',
			'address'=>'Long and winding road 777', 'gender'=>'Male',
			'dni'=>30300123,'other'=>'CEO'
			]);
		$person9=Person::create(['first_name'=>'Jorge',
		 'last_name'=>'Rial',
			'address'=>'Callao 900', 'gender'=>'Male',
			'dni'=>30400123,'other'=>'Actor'
			]);
		
		
		//Interactions
		$person1->interactions()->save(new Interaction(['text'=>'La persona recibio Atencion Medica',
		 'date'=>'2015-4-20']));
		$person2->interactions()->save(new Interaction(['text'=>'Persona con necesidad de obtener documento nacional de identidad',
		 'date'=>'2015-4-20']));
		$person2->interactions()->save(new Interaction(['text'=>'Persona asistio a comedor (Comedor X)',
		 'date'=>'2015-4-20']));
		$person3->interactions()->save(new Interaction(['text'=>'Se le dio ropa a la persona',
		 'date'=>'2015-4-20']));
	}
}
class UserTableSeeder extends Seeder{
	public function run(){
		User::create(['name'=>'Luciano Delorenzi',
		 'email'=>'lgdelorenzi2@gmail.com',
			'password'=>Hash::make('delorenzi')]);
		User::create(['name'=>'Enzo Sagretti',
		 'email'=>'enzosagretti2@gmail.com',
			'password'=>Hash::make('sagretti')]);
		User::create(['name'=>'Agustin Puentes',
		 'email'=>'aguspuentes2@hotmail.com',
			'password'=>Hash::make('puentes')]);
	}
}
