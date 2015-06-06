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
		$this->call('UserRolesAndPermissionsSeeder');
	}
}


class UserRolesAndPermissionsSeeder extends Seeder {

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
        $explorer->display_name = 'Samaritano'; // optional
        $explorer->description  = 'Usuario explorador con acceso a las páginas de asistidos e interacciones.'; // optional
        $explorer->save();


        $newUser = new Role();
        $newUser->name         = 'new-user';
        $newUser->display_name = 'Nuevo usuario'; // optional
        $newUser->description  = 'Nuevo usuario sólo con derechos para dar de alta asistidos e interacciones.'; // optional
        $newUser->save();

        // Permissions
        $seePeopleSearchView = new Permission();
        $seePeopleSearchView->name         = 'see-people-search-view';
        $seePeopleSearchView->display_name = 'Ver página de búsqueda de asistidos'; // optional
        $seePeopleSearchView->description  = 'Ver la página de búsqueda avanzada de asistidos.'; // optional
        $seePeopleSearchView->save();

        $seeInteractionsSearchView = new Permission();
        $seeInteractionsSearchView->name         = 'see-interactions-search-view';
        $seeInteractionsSearchView->display_name = 'Ver página de búsqueda de interacciones'; // optional
        $seeInteractionsSearchView->description  = 'Ver la página de búsqueda avanzada de interacciones.'; // optional
        $seeInteractionsSearchView->save();

        $seeUsersSearchView = new Permission();
        $seeUsersSearchView->name         = 'see-users-search-view';
        $seeUsersSearchView->display_name = 'Ver página de búsqueda de usuarios'; // optional
        $seeUsersSearchView->description  = 'Ver la página de búsqueda avanzada de usuarios.'; // optional
        $seeUsersSearchView->save();

        $seeTags = new Permission();
        $seeTags->name         = 'see-tags';
        $seeTags->display_name = 'Ver etiquetas'; // optional
        $seeTags->description  = 'Ver las etiquetas existentes.'; // optional
        $seeTags->save();

        $editTags = new Permission();
        $editTags->name         = 'edit-tags';
        $editTags->display_name = 'Editar etiquetas'; // optional
        $editTags->description  = 'Editar las etiquetas del sistema.'; // optional
        $editTags->save();

        $addTag = new Permission();
        $addTag->name         = 'add-tag';
        $addTag->display_name = 'Agregar etiquetas'; // optional
        $addTag->description  = 'Agregar nuevas etiquetas.'; // optional
        $addTag->save();

        $seeUsers = new Permission();
        $seeUsers->name         = 'see-users';
        $seeUsers->display_name = 'Ver usuarios'; // optional
        $seeUsers->description  = 'Ver los usuarios existentes.'; // optional
        $seeUsers->save();

        $editUsers = new Permission();
        $editUsers->name         = 'edit-users';
        $editUsers->display_name = 'Editar usuarios'; // optional
        $editUsers->description  = 'Editar permisos de los usuarios existentes.'; // optional
        $editUsers->save();

        $seeAllPeople = new Permission();
        $seeAllPeople->name         = 'see-all-people';
        $seeAllPeople->display_name = 'Ver asistidos'; // optional
        $seeAllPeople->description  = 'Ver los asistidos existentes.'; // optional
        $seeAllPeople->save();

        $seeNewPeople = new Permission();
        $seeNewPeople->name         = 'see-new-people';
        $seeNewPeople->display_name = 'Ver nuevos asistidos'; // optional
        $seeNewPeople->description  = 'Ver sólo los nuevos asistidos creados por el usuario.'; // optional
        $seeNewPeople->save();

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

        $editNewPeople = new Permission();
        $editNewPeople->name         = 'edit-new-people';
        $editNewPeople->display_name = 'Editar nuevos asistidos'; // optional
        $editNewPeople->description  = 'Editar sólo los asistidos creados por el usuario.'; // optional
        $editNewPeople->save();

        $seeAllInteractions = new Permission();
        $seeAllInteractions->name         = 'see-all-interactions';
        $seeAllInteractions->display_name = 'Ver interacciones'; // optional
        $seeAllInteractions->description  = 'Ver las interacciones existentes.'; // optional
        $seeAllInteractions->save();

        $seeNewInteractions = new Permission();
        $seeNewInteractions->name         = 'see-new-interactions';
        $seeNewInteractions->display_name = 'Ver nuevas interacciones'; // optional
        $seeNewInteractions->description  = 'Ver sólo las nuevas interacciones creadas por el usuario.'; // optional
        $seeNewInteractions->save();

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

        $editNewInteractions = new Permission();
        $editNewInteractions->name         = 'edit-new-interactions';
        $editNewInteractions->display_name = 'Editar nuevas interacciones'; // optional
        $editNewInteractions->description  = 'Editar sólo las interacciones creadas por el usuario.'; // optional
        $editNewInteractions->save();

        $createTags = new Permission();
        $createTags->name = 'create-tags';
        $createTags->display_name = 'Crear nuevos tags';
        $createTags->description = 'Crear nuevos tags';
        $createTags->save();

        // Add Permisions to Roles
        $admin->attachPermissions(array($seeUsersSearchView, $seeUsers, $editUsers,
                                        $seeTags, $editTags, $addTag, $createTags,
                                        $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                        $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $posadero->attachPermissions(array($seeUsersSearchView, $seeUsers,
                                           $seeTags, $editTags, $addTag,
                                           $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                           $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $explorer->attachPermissions(array($seeTags, $editTags, $addTag,
                                           $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                           $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $newUser->attachPermissions(array($seeTags, $editTags, $addTag,
                                          $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editNewPeople,
                                          $seeInteractionsSearchView, $seeNewInteractions, $addInteraction, $editNewInteractions));

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
		$interaction1 = new Interaction(['text'=>'La persona recibió atención médica.',
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

		$interaction3 = new Interaction(['text'=>'La persona asistió a comedor comunitario.',
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
