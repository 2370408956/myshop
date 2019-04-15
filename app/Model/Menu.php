<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey='m_id';
    protected $table='menu';
    public $timestamps=false;
}
