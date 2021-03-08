<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lib_provinces extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'lib_provinces';

    public function region()
    {
        return $this->hasOne('App\lib_regions', 'region_code', 'region_code' );
    }
}
