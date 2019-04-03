<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    protected $table='username';
    protected $primaryKey='u_id';
    public $timestamps=false;
}
