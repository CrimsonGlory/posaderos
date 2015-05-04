<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Interaction;
use App\FileEntry;
use App\User;

class Person extends Model {
use \Conner\Tagging\TaggableTrait;
    protected $table = 'people';
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
        if ($date != null)
        {
            $this->attributes['birthdate'] = Carbon::createFromFormat('Y-m-d', $date);
        }
    }

    public function interactions()
    {
	    return $this->hasMany('App\Interaction','person_id');
    }

    public function fileentries()
    {
        return $this->morphToMany('App\FileEntry','fileentrieable');
    }

    public function creator()
    {
	    return $this->belongsTo('App\User','created_by');
    }

    public function last_update_user()
    {
        return $this->belongsTo('App\User','updated_by');
    }

   public function name()
   {
        return $this->first_name." ".$this->last_name;
   }

}
