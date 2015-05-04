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
}
