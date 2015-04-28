<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;
use App\User;
use Carbon\Carbon;
class Interaction extends Model {
use \Conner\Tagging\TaggableTrait;
	protected $table = 'interactions';
	protected $fillable = [
		'text',
		'date',
		'fixed',
		'person_id'];	

	public function person()
	{
		return $this->belongsTo('App\Person');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Para que agregue la hora al guardar y no sólo el día
    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
    }
}
