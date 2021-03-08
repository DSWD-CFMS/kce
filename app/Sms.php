<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'sms_in';
}