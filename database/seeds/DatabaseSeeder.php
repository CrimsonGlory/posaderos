<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Person;
use App\Interaction;
use App\User;
use Conner\Tagging\Tag;
use Illuminate\Database\Schema\Blueprint;


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
	    Schema::table('people', function(Blueprint $table) {$table->dropForeign('people_avatar_foreign');});
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
	    Schema::table('people', function(Blueprint $table) {$table->foreign('avatar')->references('id')->on('fileentries');});
    }
}

class RolesAndPermissionsSeeder extends Seeder {

	public function run()
    {
        create_roles_and_permissions();
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
