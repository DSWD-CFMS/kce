<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp_logs extends Model 
{

    protected $table = 'sp_logs';
    public $timestamps = true;

    public function Sp()
    {
        // return $this->belongsTo('Sp');
        return $this->belongsTo('App\Sp', 'sp_id', 'sp_id');
    }

}