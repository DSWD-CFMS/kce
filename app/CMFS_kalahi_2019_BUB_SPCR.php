<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2019_BUB_SPCR extends Model
{
    protected $connection = 'mysql9';
    protected $table = 'tbl_spcrcoa_bub';

    public function CMFS_kalahi_2019_BUB_SPCR_FINDINGS()
    {
        return $this->hasMany('App\CMFS_kalahi_2019_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

}
