<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Interaction;
use App\FileEntry;
use App\User;

class Person extends Model {
    use \Conner\Tagging\TaggableTrait, \Conner\Likeable\LikeableTrait;
    
    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birthdate',
        'dni',
        'gender',
        'address',
        'other',
	    'phone'
	];

    // Para que agregue la hora al guardar y no sólo el día
    public function setBirthdateAttribute($date)
    {
        if ($date != null)
        {
            $this->attributes['birthdate'] = Carbon::createFromFormat('Y-m-d', $date);
        }
        else
        {
            $this->attributes['birthdate'] = null;
        }
    }

    public function setDNIAttribute($dni)
    {
        if ($dni != null)
        {
            $this->attributes['dni'] = $dni;
        }
        else
        {
            $this->attributes['dni'] = null;
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

   public function get_avatar()
   {
	return $this->belongsTo('App\FileEntry','avatar','id');
   }

}
