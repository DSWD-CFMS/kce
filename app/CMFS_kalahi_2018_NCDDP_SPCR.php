<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2018_NCDDP_SPCR extends Model
{
	protected $connection = 'mysql8';
    protected $table = 'tbl_spcrcoa_ncddp';

    public function CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasMany('App\CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

}
