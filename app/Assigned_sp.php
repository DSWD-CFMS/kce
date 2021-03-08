<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assigned_sp extends Model 
{

    protected $table = 'assigned_sp';
    public $timestamps = true;

    public function Sp()
    {
        return $this->hasMany('App\Sp', 'sp_id', 'sp_id');
    }

    public function Sp_groupings()
    {
        return $this->belongsTo('App\Sp_groupings', 'assigned_grouping', 'id');
    }

    public function Users()
    {
        return $this->hasMany('App\Users', 'id', 'assigned_to');
    }

}