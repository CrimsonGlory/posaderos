<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model {

    public function person()
    {
        return $this->belongsTo('Person');
    }

}
