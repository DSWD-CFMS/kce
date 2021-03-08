<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp_category extends Model 
{

    protected $table = 'sp_category';
    public $timestamps = true;

    public function Sp_groupings()
    {
        return $this->belongsTo('App\Sp_groupings');
    }

}