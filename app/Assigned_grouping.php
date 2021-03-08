<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assigned_grouping extends Model 
{

    protected $table = 'assigned_grouping';
    public $timestamps = true;

    public function Sp_groupings()
    {
        return $this->hasMany('App\Sp_groupings', 'id', 'sp_grouping_id');
    }

    public function Sp()
    {
        return $this->hasMany('App\Sp', 'sp_groupings', 'sp_grouping_id');
    }

    public function Users()
    {
        return $this->hasOne('App\Users', 'id', 'assigned_to');
    }

}
