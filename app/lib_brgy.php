<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lib_brgy extends Model
{
    protected $connection = 'mysql2K20';
    protected $table = 'lib_brgy';

    public function cities()
    {
        return $this->hasOne('App\lib_cities', 'city_code', 'city_code' );
    }

}
