<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

class Interaction extends Model {
	protected $table = 'interactions';
	protected $fillable = [
		'text',
		'date',
		'fixed',
		'person_id'];	

	public function person()
	{
		return $this->belongsTo('Person');
	}
}
