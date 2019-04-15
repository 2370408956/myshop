<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table='material';
    public $updated_at=false;
    protected $primaryKey='material';
}