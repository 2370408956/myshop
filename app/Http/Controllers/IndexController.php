<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cate;
class IndexController extends Controller
{
    //首页
    public function index()
    {
//        echo session('u_id');die;
        $info=Goods::limit(8)->get();
        $cateinfo=Cate::where('pid',0)->limit(5)->get();
        return view('index',['info'=>$info,'cateinfo'=>$cateinfo]);
    }






}
