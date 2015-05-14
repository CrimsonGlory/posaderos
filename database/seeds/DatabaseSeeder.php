<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Person;
use App\Interaction;
use App\User;
use App\Role;
use App\Permission;

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
		DB::table('fileentrieables')->delete();
		DB::table('fileentries')->delete();
		DB::table('interactions')->delete();
		DB::table('people')->delete();
		DB::table('users')->delete();
		DB::table('password_resets')->delete();
		DB::table('tagging_tagged')->delete();
		DB::table('tagging_tags')->delete();
        DB::table('permission_role')->delete();
        DB::table('permissions')->delete();
        DB::table('role_user')->delete();
        DB::table('roles')->delete();

        // Roles
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrador'; // optional
        $admin->description  = 'Usuario administrador con acceso completo e irrestricto.'; // optional
        $admin->save();

        $posadero = new Role();
        $posadero->name         = 'posadero';
        $posadero->display_name = 'Posadero'; // optional
        $posadero->description  = 'Usuario avanzado con acceso a las páginas de asistidos, interacciones y usuarios.'; // optional
        $posadero->save();

        $explorer = new Role();
        $explorer->name         = 'explorer';
        $explorer->display_name = 'Explorador'; // optional
        $explorer->description  = 'Usuario explorador con acceso a las páginas de asistidos e interacciones.'; // optional
        $explorer->save();


        $newUser = new Role();
        $newUser->name         = 'new-user';
        $newUser->display_name = 'Nuevo usuario'; // optional
        $newUser->description  = 'Nuevo usuario sólo con derechos para dar de alta asistidos e interacciones.'; // optional
        $newUser->save();

        // Permissions
        $seeSearchView = new Permission();
        $seeSearchView->name         = 'see-search-view';
        $seeSearchView->display_name = 'Ver página de búsqueda'; // optional
        $seeSearchView->description  = 'Ver la página de búsqueda avanzada.'; // optional
        $seeSearchView->save();

        $seeUsers = new Permission();
        $seeUsers->name         = 'see-users';
        $seeUsers->display_name = 'Ver Usuarios'; // optional
        $seeUsers->description  = 'Ver los usuarios existentes.'; // optional
        $seeUsers->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Editar Usuarios'; // optional
        $editUser->description  = 'Editar permisos de los usuarios existentes.'; // optional
        $editUser->save();

        $seePeople = new Permission();
        $seePeople->name         = 'see-people';
        $seePeople->display_name = 'Ver asistidos'; // optional
        $seePeople->description  = 'Ver los asistidos existentes.'; // optional
        $seePeople->save();

        $addPerson = new Permission();
        $addPerson->name         = 'add-person';
        $addPerson->display_name = 'Agregar asistidos'; // optional
        $addPerson->description  = 'Agregar nuevos asistidos.'; // optional
        $addPerson->save();

        $editAllPeople = new Permission();
        $editAllPeople->name         = 'edit-all-people';
        $editAllPeople->display_name = 'Editar asistidos'; // optional
        $editAllPeople->description  = 'Editar cualquier asistido del sistema.'; // optional
        $editAllPeople->save();

        $editPerson = new Permission();
        $editPerson->name         = 'edit-new-people';
        $editPerson->display_name = 'Editar nuevos asistidos'; // optional
        $editPerson->description  = 'Editar sólo los asistidos creados por el usuario.'; // optional
        $editPerson->save();

        $seeInteractions = new Permission();
        $seeInteractions->name         = 'see-interactions';
        $seeInteractions->display_name = 'Ver interacciones'; // optional
        $seeInteractions->description  = 'Ver las interacciones existentes.'; // optional
        $seeInteractions->save();

        $addInteraction = new Permission();
        $addInteraction->name         = 'add-interaction';
        $addInteraction->display_name = 'Agregar interacción'; // optional
        $addInteraction->description  = 'Agregar nuevas interacciones.'; // optional
        $addInteraction->save();

        $editAllInteractions = new Permission();
        $editAllInteractions->name         = 'edit-all-interactions';
        $editAllInteractions->display_name = 'Editar interacciones'; // optional
        $editAllInteractions->description  = 'Editar cualquier interacción del sistema.'; // optional
        $editAllInteractions->save();

        $editInteraction = new Permission();
        $editInteraction->name         = 'edit-new-interactions';
        $editInteraction->display_name = 'Editar nuevas interacciones'; // optional
        $editInteraction->description  = 'Editar sólo las interacciones creadas por el usuario.'; // optional
        $editInteraction->save();

        // Add Permisions to Roles
        $admin->attachPermissions(array($seeSearchView, $seeUsers, $editUser,
                                        $seePeople, $addPerson, $editPerson, $editAllPeople,
                                        $seeInteractions, $addInteraction, $editInteraction, $editAllInteractions));

        $posadero->attachPermissions(array($seeSearchView, $seeUsers,
                                           $seePeople, $addPerson, $editPerson, $editAllPeople,
                                           $seeInteractions, $addInteraction, $editInteraction, $editAllInteractions));

        $explorer->attachPermissions(array($seeSearchView,
                                           $seePeople, $addPerson, $editPerson, $editAllPeople,
                                           $seeInteractions, $addInteraction, $editInteraction, $editAllInteractions));

        $newUser->attachPermissions(array($addPerson, $editPerson,
                                          $addInteraction, $editInteraction));

		// Users
        $user0 = User::create(['name'=>'Administrador',
                               'email'=>'lumencor.posaderos@gmail.com',
                               'password'=>Hash::make('123456')]);
        $user0->attachRole($admin);

        $user1 = User::create(['name'=>'Luciano Delorenzi',
                               'email'=>'lgdelorenzi@gmail.com',
                               'password'=>Hash::make('123456')]);
        $user1->attachRole($newUser);

        $user2 = User::create(['name'=>'Enzo Sagretti',
                               'email'=>'enzosagretti@gmail.com',
                               'password'=>Hash::make('123456')]);
        $user2->attachRole($explorer);

        $user3 = User::create(['name'=>'Javier Bassi',
                               'email'=>'javierbassi@gmail.com',
                               'password'=>Hash::make('123456')]);
        $user3->attachRole($admin);

        $user4 = User::create(['name'=>'Agustin Puentes',
                               'email'=>'aguspuentes@gmail.com',
                               'password'=>Hash::make('123456')]);
        $user4->attachRole($posadero);

        // People
		$person1 = new Person;
		$person1->fill(['first_name'=>'Juan Román',
                        'last_name'=>'Riquelme',
			            'address'=>'Medrano 206',
                        'gender'=>'Male']);
		$person1->updated_by = $user1->id;
		$person1->created_by = $user1->id;
		$person1->save();

		$person2 = new Person;
		$person2->fill(['first_name'=>'Carlos',
		                'last_name'=>'Navarro Montoya',
			            'address'=>'Callao 102',
                        'gender'=>'Male']);
		$person2->updated_by = $user1->id;
        $person2->created_by = $user1->id;
		$person2->save();

		$person3 = new Person;
		$person3->fill(['first_name'=>'Carlos',
		                'last_name'=>'Mac Allister',
			            'address'=>'Maipu 1502',
                        'gender'=>'Male']);
		$person3->updated_by = $user1->id;
        $person3->created_by = $user1->id;
        $person3->save();

		$person4 = new Person;
		$person4->fill(['first_name'=>'Diego Armando',
		                'last_name'=>'Maradona',
			            'address'=>'Corrientes 503',
                        'gender'=>'Male']);
		$person4->updated_by = $user1->id;
        $person4->created_by = $user1->id;
        $person4->save();

		$person5 = new Person;
		$person5->fill(['first_name'=>'Valeria',
		                'last_name'=>'Mazza',
			            'address'=>'Callao 1231',
                        'gender'=>'Female',
			            'dni'=>12121212,
                        'other'=>'Miente al dar el nombre.']);
		$person5->updated_by = $user3->id;
        $person5->created_by = $user3->id;
        $person5->save();

		$person6 = new Person;
		$person6->fill(['first_name'=>'Ronaldinho',
		                'last_name'=>'Gaucho',
			            'address'=>'Av. Brasil 789',
                        'gender'=>'Male',
			            'dni'=>23232323,
                        'other'=>'Futbolista']);
		$person6->updated_by = $user1->id;
        $person6->created_by = $user1->id;
        $person6->save();

		$person7 = new Person;
		$person7->fill(['first_name'=>'Mark',
		                'last_name'=>'Zuckerberg',
			            'address'=>'Silicon Valley 123',
                        'gender'=>'Male',
			            'dni'=>34343434,
                        'other'=>'Desarrollador']);
		$person7->updated_by = $user1->id;
        $person7->created_by = $user1->id;
        $person7->save();

		$person8 = new Person;
		$person8->fill(['first_name'=>'Bill',
		                'last_name'=>'Gates',
			            'address'=>'Long and winding road 777',
                        'gender'=>'Male',
                        'dni'=>45454545,
                        'other'=>'CEO']);
		$person8->updated_by = $user2->id;
        $person8->created_by = $user2->id;
        $person8->save();

		$person9 = new Person;
		$person9->fill(['first_name'=>'Jorge',
		                'last_name'=>'Rial',
			            'address'=>'Callao 900',
                        'gender'=>'Male',
			            'dni'=>56565656,
                        'other'=>'Actor']);
		$person9->updated_by = $user1->id;
        $person9->created_by = $user1->id;
        $person9->save();
		
		//Interactions
		$interaction1 = new Interaction(['text'=>'La persona recibió atencion médica.',
                                         'date'=>'2015-4-20',
                                         'fixed' => 0]);
		$interaction1->user_id = $user1->id;
		$person1->interactions()->save($interaction1);
        $interaction1->tag("jugador");

		$interaction2 = new Interaction(['text'=>'Persona con necesidad de obtener documento nacional de identidad.',
                                         'date'=>'2015-4-20',
                                         'fixed' => 1]);
		$interaction2->user_id = $user2->id;
		$person2->interactions()->save($interaction2);

		$interaction3 = new Interaction(['text'=>'Persona asistió a comedor comunitario.',
                                         'date'=>'2015-4-20',
                                         'fixed' => 0]);
		$interaction3->user_id = $user1->id;
		$person2->interactions()->save($interaction3);
		$interaction3->tag("comida");

		$interaction4 = new Interaction(['text'=>'Se le entregó ropa al asistido.',
                                         'date'=>'2015-4-20',
                                         'fixed' => 0]);
		$interaction4->user_id = $user1->id;
		$person3->interactions()->save($interaction4);

		//Tags
		$person1->tag("jugador");
		$person2->tag("jugador");
		$person3->tag("jugador");
		$person4->tag("jugador");
		$person4->tag("salud");
		$person4->tag("comida");
	}
}
