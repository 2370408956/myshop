<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table='shop_category';
    public $timestamps=false;
    protected $primaryKey='cate_id';
}
