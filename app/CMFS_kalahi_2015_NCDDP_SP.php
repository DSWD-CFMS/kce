<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2015_NCDDP_SP extends Model
{
    protected $connection = 'mysql5';
    protected $table = 'tbl_ncddp_sp';

    public function brgy()
    {
        return $this->hasOne('App\lib_brgy', 'brgy_code', 'brgy_code' );
    }
    
    public function Sp()
    {
        return $this->hasOne('App\Sp', 'sp_id', 'id');
    }
}
