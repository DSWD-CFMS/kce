<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ceac extends Model 
{

    protected $table = 'ceac';
    public $timestamps = true;

    public function sp()
    {
        return $this->hasOne('Sp');
    }

}