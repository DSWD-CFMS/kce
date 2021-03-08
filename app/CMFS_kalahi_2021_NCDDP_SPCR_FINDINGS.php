<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS extends Model
{
    protected $connection = 'mysql2K21';
    protected $table = 'tbl_spcrcoa_ncddp';
    public $timestamps = false;
    
    public function CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS_LOGS()
    {
        return $this->hasMany('App\CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS_LOGS', 'sp_id', 'sp_id');
    }
}
