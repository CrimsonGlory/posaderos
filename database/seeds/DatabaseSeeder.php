<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Person;
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
		$this->call('InteractionTableSeeder');
	}

}
class PeopleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('people')->delete();
		Person::create(['first_name'=>'Juan Román',
		 'last_name'=>'Riquelme',
			'address'=>'Callao 500', 'gender'=>'Male']);
		Person::create(['first_name'=>'Carlos',
		 'last_name'=>'Navarro Montoya',
			'address'=>'Callao 501', 'gender'=>'Male']);
		Person::create(['first_name'=>'Carlos',
		 'last_name'=>'Mac Allister',
			'address'=>'Callao 502', 'gender'=>'Male']);
		Person::create(['first_name'=>'Diego Armando',
		 'last_name'=>'Maradona',
			'address'=>'Callao 503', 'gender'=>'Male']);
		Person::create(['first_name'=>'Valeria',
		 'last_name'=>'Mazza',
			'address'=>'Callao 504', 'gender'=>'Female',
			'dni'=>123455,'other'=>'algun otro dato'
			]);
		Person::create(['first_name'=>'Ronaldinho',
		 'last_name'=>'Gaucho',
			'address'=>'Av. Brasil 789', 'gender'=>'Male',
			'dni'=>30100123,'other'=>'Futbolista'
			]);
		Person::create(['first_name'=>'Mark',
		 'last_name'=>'Zuckerberg',
			'address'=>'Silicon Valley 123', 'gender'=>'Male',
			'dni'=>30200123,'other'=>'Desarrollador'
			]);
		Person::create(['first_name'=>'Bill',
		 'last_name'=>'Gates',
			'address'=>'Long and winding road 777', 'gender'=>'Male',
			'dni'=>30300123,'other'=>'CEO'
			]);
		Person::create(['first_name'=>'Jorge',
		 'last_name'=>'Rial',
			'address'=>'Callao 900', 'gender'=>'Male',
			'dni'=>30400123,'other'=>'Actor'
			]);
		
		
		// $this->call('UserTableSeeder');
	}

}
class InteractionTableSeeder extends Seeder {
	public function run(){
		DB::table('interactions')->delete();
		
		Interaction::create(['text'=>'La persona recibio Atencion Medica',
		 'date'=>'2015-4-20',
			'person_id'=>30400123]);
		Interaction::create(['text'=>'Persona con necesidad de obtener documento nacional de identidad',
		 'date'=>'2015-4-20',
			'person_id'=>30100123]);
		Interaction::create(['text'=>'Persona asistio a comedor (Comedor X)',
		 'date'=>'2015-4-20',
			'person_id'=>30200123]);
		Interaction::create(['text'=>'Se le dio ropa a la persona',
		 'date'=>'2015-4-20',
			'person_id'=>30300123]);
	}
}
class UserTableSeeder extends Seeder{
	public function run(){
		DB::table('users')->delete();
		User::create(['name'=>'Luciano Delorenzi',
		 'email'=>'lgdelorenzi@gmail.com',
			'password'=>'delorenzi']);
		User::create(['name'=>'Enzo Sagretti',
		 'email'=>'enzosagretti@gmail.com',
			'password'=>'sagretti']);
		User::create(['name'=>'Agustin Puentes',
		 'email'=>'aguspuentes@hotmail.com',
			'password'=>'puentes']);
	}
}
	}
}
