<?php

namespace App\Http\Controllers;

use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class DemoController extends Controller
{
    public function test()
    {
//        Cache::put('name','1111',10);
//        echo Cache::get('name');
    }

    public function index(Request $request)
    {
        $search=$request->search;
        $page=$request->input('page',1);
        $key=$search.$page;
//        memcache
//        if(Cache::has($key)){
//            $goods=Cache::get($key);
//        }else{
//            $goods=Goods::where('goods_name','like',"%$search%")->paginate(3);
//            Cache::put($key,$goods,600);
//        }
//        Redis::set('name',111);die;
//        echo Redis::get('name');die;
//        var_dump(Redis::del('a'));die;
//        Redis::flushdb();die;


//        Redis
        if(Redis::exists($key)){
            echo 1;
            $goods=unserialize(Redis::get($key));
        }else{
            echo 2;
            $goods=Goods::where('goods_name','like',"%$search%")->paginate(3);
            Redis::set($key,serialize($goods));
            Redis::expire($key,600);
        }
//        dd($goods);
        return view('demo',['data'=>$goods,'search'=>$search]);
    }
}
