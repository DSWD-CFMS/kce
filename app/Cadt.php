<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadt extends Model 
{

    protected $table = 'cadt';
    public $timestamps = true;

    public function Sp()
    {
        return $this->hasMany('App\Sp', 'sp_id', 'sp_id');
    }
}