<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model 
{

    protected $table = 'gallery';
    public $timestamps = true;

    public function Gallery_Images()
    {
        return $this->hasMany('App\Gallery_Images', 'gallery_id', 'id');
    }

}