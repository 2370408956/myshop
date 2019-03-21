<?php

namespace App\Http\Controllers;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Model\Goods;
class GoodsController extends Controller
{

    //所有商品
    public function allshops($cate_id='')
    {
        $cate=Cate::where('pid',0)->get();
        if(empty($cate_id)){
            $goodsinfo=Goods::orderBy('buy_num','desc')->get();
        }else{
            $cateinfo=Cate::get();
            $c_id=soncateinfo($cateinfo,$cate_id);
            $goodsinfo=Goods::whereIn('cate_id',$c_id)->orderBy('buy_num','desc')->get();
        }
        return view('allshops',['cateinfo'=>$cate,'goodsinfo'=>$goodsinfo,'cate_id'=>$cate_id]);
    }


    //分类下的商品
    public function goodsInfo(Request $request)
    {
        $cate_id=$request->post('cate_id');
        $search=$request->post('search');
        $nav=$request->post('nav');
//        echo $nav;die;
        $cateinfo=Cate::get();
        $c_id=soncateinfo($cateinfo,$cate_id);
        if($nav==1){
            $field='buy_num';
            $asc='desc';
        }else if($nav==2){
            $field='buy_num';
            $asc='desc';
        }else if($nav==3){
            $field='self_price';
            $asc='asc';
        }else if($nav==4){
            $field='self_price';
            $asc='desc';
        }

        $arr=Goods::whereIn('cate_id',$c_id)->where('goods_name','like',"%$search%")->orderBy($field,$asc)->get();
        return view('data',['goodsinfo'=>$arr]);
    }

    //商品详情页
    public function shopcontent($goods_id)
    {
        $goodsinfo=Goods::where('goods_id',$goods_id)->first();
        $goodsinfo['goods_imgs']=rtrim($goodsinfo['goods_imgs'],'|');
        $goodsinfo['goods_imgs']=explode('|',$goodsinfo['goods_imgs']);
        return view('shopcontent',['goodsinfo'=>$goodsinfo]);
    }



}
