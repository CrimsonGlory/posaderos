<?php

use App\Person;
use App\Http\Requests;
use App\Http\Requests\CreatePersonRequest;
use Carbon\Carbon;
use App\User;
class PersonTest extends TestCase {

	public function testCreatePerson()
	{
		$datosPersona = array(
			'first_name' => 'pepe',
			'last_name' => 'gomez',
			'dni' => 35333444,
			'gender' => 'male', 
			'email' => 'pepe@gmail.com',
			'address' => 'san martin 123',
			'other' => 'una descripción');
		$person=new Person;
		$person->fill($datosPersona);
		$user1=User::create(['name'=>'user1',
                 'email'=>'email11@gmail.com',
                        'password'=>Hash::make('asdfasdfasdf')]);
		
		$person->created_by=$user1->id;
		$person->updated_by=$user1->id;
		$person->save();
		$this->assertTrue($person->first_name == 'pepe');
		$this->assertTrue($person->last_name == 'gomez');
		$this->assertTrue($person->dni == '35333444');
		$this->assertTrue($person->gender == 'male');
		$this->assertTrue($person->email == 'pepe@gmail.com');
		$this->assertTrue($person->address == 'san martin 123');
		$this->assertTrue($person->other == 'una descripción');
	}

	public function testPersistingAPerson()
	{
		$datosPersona = array(
			'first_name' => 'pepe',
			'last_name' => 'gomez',
			'dni' => 35333444,
			'gender' => 'male', 
			'email' => 'pepe@gmail.com',
			'address' => 'san martin 123',
			'other' => 'una descripción');
		$person=new Person;
                $person->fill($datosPersona);
                $user1=User::create(['name'=>'user1',
                 'email'=>'email8@gmail.com',
                        'password'=>Hash::make('asdfasdfasdf')]);
		$person->created_by=$user1->id;
                $person->updated_by=$user1->id;
                $person->save();
		$restoredPerson = Person::find($person->id);
		$this->assertTrue($person->first_name == $restoredPerson->first_name);
		$this->assertTrue($person->last_name == $restoredPerson->last_name);
		$this->assertTrue($person->dni == $restoredPerson->dni);
	}

	public function testLoginRedirection ()
	{
		$response = $this->call('GET','/');
		$this->assertResponseStatus(302);
		$this->assertRedirectedTo('/auth/login');
	}


}
