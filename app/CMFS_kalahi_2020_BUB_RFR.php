<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2020_BUB_RFR extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'tbl_incoming_bub';

    public function CMFS_kalahi_2020_BUB_RFR_FINDINGS()
    {
        return $this->hasMany('App\CMFS_kalahi_2020_BUB_RFR_FINDINGS', 'rfr_id', 'id');
    }
}
