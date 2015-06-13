<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Astroanu\ImageCache\Uploader;

class Fileentry extends Model {
protected $filedir = 'fileentries';//used by larave-image-cache
    public function people()
    {
        return $this->morphedByMany('App\Person','fileentrieable');
    }

    public function interactions()
    {
	return $this->morphedByMany('App\Interaction','fileentrieable');
    }
    public function upload($file)
    {
	if(!is_null($file))
	{
		$this->mime = $file->getClientMimeType();
	        $this->original_filename = $file->getClientOriginalName();
		$this->filename=Uploader::upload($file,$this->filedir);
	}
    }
    public function avatar_of()
    {
	return $this->hasOne('App\Person','avatar','id');
    }
    public function scopeImage($query)
    {
	return $query->whereNested(function($sql) {
		$sql->where('mime','=','image/jpeg');
		$sql->orWhere('mime','=','image/png');
		$sql->orWhere('mime','=','image/gif');
	});
    }

    public function isImage()
    {
//	return substr($this->mime, 0, 5) == 'image';
	return in_array($this->mime,['image/jpeg','image/png','image/gif']);
    }


    public function scopeNotImage($query)
    {
        return $query->
                where('mime','<>','image/jpeg')->
                where('mime','<>','image/png')->
                where('mime','<>','image/gif');
    }

}
