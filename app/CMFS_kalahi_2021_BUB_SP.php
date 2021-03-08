<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMFS_kalahi_2021_BUB_SP extends Model
{
    protected $connection = 'mysql2K21';
    protected $table = 'tbl_sp_bub';

    public function brgy()
    {
        return $this->hasOne('App\lib_brgy', 'brgy_code', 'brgy_code' );
    }

	public function sp() {
		return $this->hasOne('App\Sp', 'sp_id', 'id');

		// return $this->belongsTo(Sp::class, env('DB_CONNECTION').'.sp', 'sp_id', 'id');
	}
}
