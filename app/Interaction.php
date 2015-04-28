<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Person;
use Carbon\Carbon;
class Interaction extends Eloquent {
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

	// Para que agregue la hora al guardar y no sólo el día
    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
    }
}
