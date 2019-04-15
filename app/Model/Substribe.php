<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Substribe extends Model
{
    protected $table='subscribe';
    protected $primaryKey='s_id';
    public $updated_at=false;
}
