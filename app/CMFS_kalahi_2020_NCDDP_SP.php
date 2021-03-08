<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2020_NCDDP_SP extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'tbl_ncddp_sp';

    public function brgy()
    {
        return $this->hasOne('App\lib_brgy', 'brgy_code', 'brgy_code' );
    }

	public function sp() {
		return $this->belongsTo('App\Sp', 'sp_id', 'sp_id');
	}
}
