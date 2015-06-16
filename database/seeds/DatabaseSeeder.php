<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Person;
use App\Interaction;
use App\User;
use App\Role;
use App\Permission;
use Conner\Tagging\Tag;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call('DropDatabase');
		$this->call('RolesAndPermissionsSeeder');
        $this->call('TagsSeeder');
        $this->call('UsersSeeder');
        $this->call('PeopleSeeder');
        $this->call('InteractionsSeeder');
        $this->call('UsersFavoritesSeeder');
	}
}

class DropDatabase extends Seeder {

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
    }
}

class RolesAndPermissionsSeeder extends Seeder {

	public function run()
	{
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

        $seeNotImageFiles = new Permission();
        $seeNotImageFiles->name         = 'see-not-image-files';
        $seeNotImageFiles->display_name = 'Ver archivos subidos'; // optional
        $seeNotImageFiles->description  = 'Ver todos los archivos subidos.'; // optional
        $seeNotImageFiles->save();

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

        // Add Permisions to Roles
        $admin->attachPermissions(array($seeUsersSearchView, $seeUsers, $editUsers,
                                        $seeTags, $editTags, $addTag, $seeNotImageFiles,
                                        $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                        $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $posadero->attachPermissions(array($seeUsersSearchView, $seeUsers,
                                           $seeTags, $seeNotImageFiles,
                                           $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                           $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $explorer->attachPermissions(array($seeTags,
                                           $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                           $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions));

        $newUser->attachPermissions(array($seeTags,
                                          $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editNewPeople,
                                          $seeInteractionsSearchView, $seeNewInteractions, $addInteraction, $editNewInteractions));
	}

}

class TagsSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create(trans('messages.locale'));
        for ($i = 0; $i < trans('messages.tagsSize'); $i++)
        {
            $tagName = strtolower(removeAccents(strtr(trim($faker->word), array(' ' => '-'))));
            if (!preg_match('/^[a-zA-Z0-9-]+$/i', $tagName))
            {
                $i--;
            }
            else
            {
                $repeatedTag = Tag::groupBy('name')->where('name', $tagName)->first();
                if ($repeatedTag != null)
                {
                    $i--;
                }
                else
                {
                    $tag = array('name' => $tagName);
                    Tag::create($tag);
                }
            }
        }
    }

}

class UsersSeeder extends Seeder {

    public function run()
    {
        // Roles
        $admin    = Role::where('name', 'admin')->first();
        $posadero = Role::where('name', 'posadero')->first();
        $explorer = Role::where('name', 'explorer')->first();
        $newUser  = Role::where('name', 'new-user')->first();

        // Test users
        $faker = Faker\Factory::create(trans('messages.locale'));
        $user = User::create(['name'     => 'Admin',
                              'email'    => 'admin@admin.com',
                              'phone'    => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                              'password' => Hash::make('123456')]);
        $user->attachRole($admin);
        $tagsSize = rand(1,trans('messages.maxTagsForUsers'));
        $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
        $tagNames = array();
        foreach ($tags as $tag)
        {
            array_push($tagNames, $tag->name);
        }
        $user->retag($tagNames);

        $user = User::create(['name'     => 'Posadero',
                              'email'    => 'posadero@posadero.com',
                              'phone'    => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                              'password' => Hash::make('123456')]);
        $user->attachRole($posadero);
        $tagsSize = rand(1,trans('messages.maxTagsForUsers'));
        $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
        $tagNames = array();
        foreach ($tags as $tag)
        {
            array_push($tagNames, $tag->name);
        }
        $user->retag($tagNames);

        $user = User::create(['name'     => 'Samaritano',
                              'email'    => 'samaritano@samaritano.com',
                              'phone'    => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                              'password' => Hash::make('123456')]);
        $user->attachRole($explorer);
        $tagsSize = rand(1,trans('messages.maxTagsForUsers'));
        $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
        $tagNames = array();
        foreach ($tags as $tag)
        {
            array_push($tagNames, $tag->name);
        }
        $user->retag($tagNames);

        $user = User::create(['name'     => 'New User',
                              'email'    => 'new-user@new-user.com',
                              'phone'    => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                              'password' => Hash::make('123456')]);
        $user->attachRole($newUser);
        $tagsSize = rand(1,trans('messages.maxTagsForUsers'));
        $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
        $tagNames = array();
        foreach ($tags as $tag)
        {
            array_push($tagNames, $tag->name);
        }
        $user->retag($tagNames);

        // Random users
        for ($i = 0; $i < trans('messages.usersSize'); $i++)
        {
            $user = User::create(['name'     => $faker->name,
                                  'email'    => $faker->email,
                                  'phone'    => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                                  'password' => Hash::make('123456')]);

            $role = rand(1,3);
            if ($role == 1)
                $user->attachRole($posadero);
            else if ($role == 2)
                $user->attachRole($explorer);
            else if ($role == 3)
                $user->attachRole($newUser);

            $tagsSize = rand(0,trans('messages.maxTagsForUsers'));
            if ($tagsSize > 0)
            {
                $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
                $tagNames = array();
                foreach ($tags as $tag)
                {
                    array_push($tagNames, $tag->name);
                }
                $user->retag($tagNames);
            }
        }
    }

}

class PeopleSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create(trans('messages.locale'));
        for ($i = 0; $i < trans('messages.peopleSize'); $i++)
        {
            $creatorUser = User::orderByRaw('RAND()')->first();
            $updaterUser = User::orderByRaw('RAND()')->first();
            $gender = ((bool)rand(0,1)? 'male' : 'female');

            $person = Person::create(['first_name' => (($gender == 'male')? $faker->firstNameMale : $faker->firstNameFemale),
                                      'last_name'  => $faker->lastName,
                                      'gender'     => $gender,
                                      'dni'        => $faker->numberBetween($min = 4000000, $max = 40000000),
                                      'birthdate'  => ((bool)rand(0,1)? $faker->date($format = 'Y-m-d', $max = 'now') : null),
                                      'address'    => ((bool)rand(0,1)? $faker->address : null),
                                      'phone'      => ((bool)rand(0,1)? parse_phone('4'.$faker->numberBetween($min = 1000000, $max = 9999999)) : null),
                                      'email'      => ((bool)rand(0,1)? $faker->email : null),
                                      'other'      => ((bool)rand(0,1)? $faker->text($maxNbChars = 100) : null),
                                      'created_by' => $creatorUser->id,
                                      'updated_by' => $updaterUser->id]);

            $tagsSize = rand(0,trans('messages.maxTagsForPeople'));
            if ($tagsSize > 0)
            {
                $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
                $tagNames = array();
                foreach ($tags as $tag)
                {
                    array_push($tagNames, $tag->name);
                }
                $person->retag($tagNames);
            }
        }
    }

}

class InteractionsSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create(trans('messages.locale'));
        $people = Person::get();
        foreach($people as $person)
        {
            $interactionsSize = rand(0,trans('messages.maxSizeInteractions'));
            for ($i = 0; $i < $interactionsSize; $i++)
            {
                $creatorUser = User::orderByRaw('RAND()')->first();

                $interaction = Interaction::create(['person_id' => $person->id,
                                                    'text'      => $faker->text($maxNbChars = 100),
                                                    'date'      => $faker->dateTimeBetween($startDate = '-8 years', $endDate = 'now')->format('Y-m-d'),
                                                    'fixed'     => (bool)rand(0,1),
                                                    'user_id'   => $creatorUser->id]);

                $tagsSize = rand(0,trans('messages.maxTagsForInteractions'));
                if ($tagsSize > 0)
                {
                    $tags = Tag::orderByRaw('RAND()')->take($tagsSize)->get();
                    $tagNames = array();
                    foreach ($tags as $tag)
                    {
                        array_push($tagNames, $tag->name);
                    }
                    $interaction->retag($tagNames);
                }
            }
        }
    }

}

class UsersFavoritesSeeder extends Seeder {

    public function run()
    {
        $users = User::get();
        foreach($users as $user)
        {
            $favoritesSize = rand(0,trans('messages.maxFavoritesForUsers'));
            if ($favoritesSize > 0)
            {
                $people = Person::orderByRaw('RAND()')->take($favoritesSize)->get();
                foreach ($people as $person)
                {
                    $person->like($user->id);
                }
            }
        }
    }

}
