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
        $time['h']=2;
        $time['i']=45;
        $time['s']=1;
        $info=Goods::limit(8)->get();
        $cateinfo=Cate::where('pid',0)->limit(5)->get();
        return view('index',['info'=>$info,'cateinfo'=>$cateinfo,'time'=>$time]);
    }






}
