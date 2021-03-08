<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model 
{

    protected $table = 'files';
    public $timestamps = true;

    public function Users()
    {
        return $this->hasOne('App\Users', 'id', 'origin');
    }

}