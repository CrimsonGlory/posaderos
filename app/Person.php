<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Interaction;

class Person extends Model {

	protected $fillable = [
	'first_name',
	'last_name',
	'email',
	'birthdate',
	'dni',
	'gender',
	'address',
	'other'
	];
	public function interactions()
	{
		return $this->hasMany('App\Interaction');
	}

}
