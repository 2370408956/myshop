<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $primaryKey='id';
    protected $table='shop_order_detail';
    public $timestamps=false;
}
