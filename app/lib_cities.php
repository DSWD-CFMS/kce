<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lib_cities extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'lib_cities';

    public function provinces()
    {
        return $this->hasOne('App\lib_provinces', 'prov_code', 'prov_code' );
    }

}
