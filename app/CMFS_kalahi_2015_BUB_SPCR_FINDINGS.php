<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2015_BUB_SPCR_FINDINGS extends Model
{
    protected $connection = 'mysql5';
    protected $table = 'tbl_spcrcoa_bub_findings';
    public $timestamps = false;

    public function CMFS_kalahi_2015_BUB_SPCR_FINDINGS_LOGS()
    {
        return $this->hasMany('App\CMFS_kalahi_2015_BUB_SPCR_FINDINGS_LOGS', 'sp_id', 'sp_id');
    }
}
