<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    public function Assigned_grouping(){
        return $this->hasMany('App\Assigned_grouping', 'assigned_to', 'id');
    }

    public function Assigned_sp()
    {
        return $this->hasMany('App\Assigned_sp', 'assigned_to', 'id');
    }

	public function Sp_groupings()
    {
        return $this->hasMany('App\Sp_groupings', 'id', 'assigned_grouping');
    }

    public function Files()
    {
        return $this->hasMany('App\Files', 'origin', 'id');
    }
}
