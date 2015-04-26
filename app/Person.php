<?php namespace App;

use Carbon\Carbon;
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

    // Para que agregue la hora al guardar y no sólo el día
    public function setBirthdateAttribute($date)
    {
        //$this->attributes['birthdate'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function interactions()
    {
	return $this->hasMany('App\Interaction','person_id');
    }
}
