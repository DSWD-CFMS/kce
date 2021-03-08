<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp_pmr extends Model 
{

    protected $table = 'sp_pmr';
    public $timestamps = true;

    public function Sp()
    {
        return $this->hasOne('App\Sp', 'sp_id', 'sp_id');
    }

    public function Sp_pmr_logs()
    {
        return $this->hasMany('App\Sp_pmr_logs', 'pmr_id', 'id');
    }
    
    public function Sp_pmr_remarks_logs()
    {
        return $this->hasMany('App\Sp_pmr_remarks_logs', 'pmr_id', 'id');
    }
}