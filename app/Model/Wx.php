<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wx extends Model
{
    protected $table='wechat';
    protected $primaryKey='w_id';
    public $timestamps=false;
}
