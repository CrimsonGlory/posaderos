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
	}
}


class PeopleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('interactions')->delete();
		DB::table('people')->delete();
		DB::table('users')->delete();
		DB::table('fileentries')->delete();
		DB::table('password_resets')->delete();
		DB::table('tagging_tagged')->delete();
		DB::table('tagging_tags')->delete();

		//Users
	         $user1=User::create(['name'=>'Luciano Delorenzi',
                 'email'=>'lgdelorenzi2@gmail.com',
                        'password'=>Hash::make('delorenzi')]);
                $user2=User::create(['name'=>'Enzo Sagretti',
                 'email'=>'enzosagretti2@gmail.com',
                        'password'=>Hash::make('sagretti')]);
                $user3=User::create(['name'=>'Agustin Puentes',
                 'email'=>'aguspuentes2@hotmail.com',
                        'password'=>Hash::make('puentes')]);

		$person1=new Person;
		$person1->fill(['first_name'=>'Juan Román',
		 'last_name'=>'Riquelme',
			'address'=>'Callao 500', 'gender'=>'Male']);
		$person1->updated_by=$user1->id;
		$person1->created_by=$user1->id;
		$person1->save();
		$person2=new Person;
		$person2->fill(['first_name'=>'Carlos',
		 'last_name'=>'Navarro Montoya',
			'address'=>'Callao 501', 'gender'=>'Male']);
		$person2->updated_by=$user1->id;
                $person2->created_by=$user1->id;
		$person2->save();
		$person3=new Person;
		$person3->fill(['first_name'=>'Carlos',
		 'last_name'=>'Mac Allister',
			'address'=>'Callao 502', 'gender'=>'Male']);
		$person3->updated_by=$user1->id;
                $person3->created_by=$user1->id;
                $person3->save();
		$person4=new Person;
		$person4->fill(['first_name'=>'Diego Armando',
		 'last_name'=>'Maradona',
			'address'=>'Callao 503', 'gender'=>'Male']);
		$person4->updated_by=$user1->id;
                $person4->created_by=$user1->id;
                $person4->save();
		$person5=new Person;
		$person5->fill(['first_name'=>'Valeria',
		 'last_name'=>'Mazza',
			'address'=>'Callao 504', 'gender'=>'Female',
			'dni'=>123455,'other'=>'algun otro dato'
			]);
		$person5->updated_by=$user3->id;
                $person5->created_by=$user3->id;
                $person5->save();
		$person6=new Person;
		$person6->fill(['first_name'=>'Ronaldinho',
		 'last_name'=>'Gaucho',
			'address'=>'Av. Brasil 789', 'gender'=>'Male',
			'dni'=>30100123,'other'=>'Futbolista'
			]);
		$person6->updated_by=$user1->id;
                $person6->created_by=$user1->id;
                $person6->save();
		$person7=new Person;
		$person7->fill(['first_name'=>'Mark',
		 'last_name'=>'Zuckerberg',
			'address'=>'Silicon Valley 123', 'gender'=>'Male',
			'dni'=>30200123,'other'=>'Desarrollador'
			]);
		$person7->updated_by=$user1->id;
                $person7->created_by=$user1->id;
                $person7->save();
		$person8=new Person;
		$person8->fill(['first_name'=>'Bill',
		 'last_name'=>'Gates',
			'address'=>'Long and winding road 777', 'gender'=>'Male',
			'dni'=>30300123,'other'=>'CEO'
			]);
		$person8->updated_by=$user2->id;
                $person8->created_by=$user2->id;
                $person8->save();
		$person9=new Person;
		$person9->fill(['first_name'=>'Jorge',
		 'last_name'=>'Rial',
			'address'=>'Callao 900', 'gender'=>'Male',
			'dni'=>30400123,'other'=>'Actor'
			]);
		$person9->updated_by=$user1->id;
                $person9->created_by=$user1->id;
                $person9->save();	
		
		//Interactions
		$interaction11=new Interaction(['text'=>'La persona recibio Atencion Medica',
                 'date'=>'2015-4-20']);
		$interaction11->user_id=$user1->id;
		$person1->interactions()->save($interaction11);
		$interaction22=new Interaction(['text'=>'Persona con necesidad de obtener documento nacional de identidad',
                 'date'=>'2015-4-20']);
		$interaction22->user_id=$user2->id;
		$person2->interactions()->save($interaction22);
		$interaction21=new Interaction(['text'=>'Persona asistio a comedor (Comedor X)',
                 'date'=>'2015-4-20']);
		$interaction21->user_id=$user1->id;
		$person2->interactions()->save($interaction21);
		$interaction21->tag("comida");
		$interaction31=new Interaction(['text'=>'Se le dio ropa a la persona',
                 'date'=>'2015-4-20']);
		$interaction31->user_id=$user1->id;
		$person3->interactions()->save($interaction31);

		//Tags
		$person1->tag("jugador");
		$person2->tag("jugador");
		$person3->tag("jugador");
		$person4->tag("jugador");
		$person4->tag("salud");
		$person4->tag("comida");
	}
}

