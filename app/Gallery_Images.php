<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery_Images extends Model 
{

    protected $table = 'gallery_images';
    public $timestamps = true;

	public function Gallery()
    {
        return $this->hasMany('App\Gallery', 'id', 'gallery_id');
    }

}