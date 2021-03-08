<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2020_NCDDP_RFR_FINDINGS extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'tbl_ncddp_finding';
    public $timestamps = false;
}
