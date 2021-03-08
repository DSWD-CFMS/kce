<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp_groupings extends Model 
{

    protected $table = 'sp_groupings';
    public $timestamps = true;

    public function Assigned_sp()
    {
        return $this->hasMany('App\Assigned_sp', 'assigned_grouping', 'id');
    }

    public function Assigned_grouping()
    {
        return $this->hasMany('App\Assigned_grouping', 'sp_grouping_id', 'id');
    }

    public function Sp_category()
    {
        return $this->hasMany('App\Sp_category');
    }
}