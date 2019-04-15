<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\Types\Compound;
use PHPUnit\Framework\Test;

class MenuController extends Controller
{
    /**
     * @return 菜单页面 获取微信菜单信息
     */
    public function menu()
    {
        $path=public_path().'/wx/menu.txt';
        $info=file_get_contents($path);
        //判断文件中是否有菜单
        if(!empty($info)){
            $data=explode('|',$info);
            $str=json_decode($data[0],true)['button'];
            return view('admin.menu',['data'=>$str,'is_start'=>$data[1]]);
        }else{
            //文件里没有，向微信获取菜单信息
            $token=Wechat::getAccess_token();
            $url='https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$token;
            $data=file_get_contents($url);
            $data=json_decode($data,true);
            //微信没有菜单
            if(isset($data['errcode'])){
                return view('admin.menu',['is_start'=>2]);
            }else{
                //获取到菜单，保存到文件里
                $info=$data['menu']['button'];
                $str=json_encode($data['menu']);
                $str=$str.'|1';
                $res=file_put_contents($path,$str);
                if($res){
                    return view('admin.menu',['data'=>$info,'is_start'=>1]);
                }
            }
        }
    }

    /**
     * 添加微信菜单
     * @return bool
     */
    public function addmenudo(Request $request)
    {
        //获取菜单数据
        $data=$request->data;
        $str=json_encode($data,JSON_UNESCAPED_UNICODE);
        $token=Wechat::getAccess_token();
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
        //将菜单信息上传给微信
        $re=Wechat::HttpPost($url,$str);
        if($re){
            //上传成功，写入文件，用1来判断是否启用
            $str=$str.'|1';
            $path=public_path().'/wx/menu.txt';
            $res=file_put_contents($path,$str);
            if($res){
                echo '上传成功';
            }else{
                echo '文件写入失败';
            }
        }else{
            echo '上传失败';
        }
        var_dump($re);
    }

    //菜单删除
    public function menudel()
    {
        //获取tooke
        $token=Wechat::getAccess_token();
        $url='https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$token;
        $re=file_get_contents($url);
        $res=json_decode($re);
        if($res->errmsg=='ok'){
            //删除菜单成功，将文件内1改为2，为未启用
            $path=public_path().'/wx/menu.txt';
            $info=file_get_contents($path);
            $data=explode('|',$info);
            $str=$data[0].'|2';
            //写入文件
            $res=file_put_contents($path,$str);
            if($res){
                echo '成功';
            }else{
                echo '失败';
            }
        }
        var_dump($re);
    }

    /**
     * 获取微信菜单，保存到数据库
     */
    public function getmenulist()
    {
        $token=Wechat::getAccess_token();
        $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$token";
        $str=file_get_contents($url);
        $data=json_decode($str,true)['menu']['button'];
//        print_r($data);die;
        $arr=[];
        $arr1=[];
        $arr2=[];
        foreach ($data as $key=>$val){
            $arr1['pid']=5;
            $arr1['name']=$val['name'];
            $arr1['type']=isset($val['type'])?$val['type']:null;
            $arr1['url']=isset($val['url'])?$val['url']:null;
            $arr1['key']=isset($val['key'])?$val['key']:null;
            $arr[]=$arr1;
            if(isset($val['sub_button'])){
                foreach ($val['sub_button'] as $k=>$v){
                    $arr2['pid']=$key;
                    $arr2['name']=$v['name'];
                    $arr2['type']=isset($v['type'])?$v['type']:null;
                    $arr2['url']=isset($v['url'])?$v['url']:null;
                    $arr2['key']=isset($v['key'])?$v['key']:null;
                    $arr[]=$arr2;
                }
            }
        }
//        print_r($arr);die;
        $re=Menu::insert($arr);
        var_dump($re);
//        $data=json_encode($str,true);
//        print_r($data);
    }


    public function menuindex()
    {
//        $info=Menu::get()->toarray();
//        $data=[];
//        foreach ($info as $k=>$v){
//            if($v['pid']==0){
//                $data[]=$v;
//            }
//        }
//        foreach ($data as $k=>$v){
//            foreach ($info as $key=>$val){
//                if($val['pid']==$v['m_id']){
//                    $data[$k]['sub_button'][]=$v;
//                }
//            }
//        }
//        print_r($data[0]['sub_button']);
//        for($i=0;$i<3;$i++){
//            echo $i;
//            print_r($data[$i]['sub_button']);
//        }
//        foreach ($data as $k=>$v){
//            @print_r($v['sub_button']);
//        }
//        die;
//        var_dump($data['sub_button']);die;
        $data=Menu::where('pid',0)->get();
        return view('admin.menuindex',['data'=>$data]);
    }

    public function menuindexadd()
    {
        $where=[
            'pid'=>0,
            'type'=>null
        ];
        $info=Menu::where($where)->get();
        return view('admin.menuindexadd',['info'=>$info]);
    }

    public function menuinfo(Request $request)
    {
        $m_id=$request->m_id;
        $arr=Menu::where('pid',$m_id)->get()->toarray();
//        var_dump($arr);die;
        return json_encode($arr);
    }
    public function menuindexado(Request $request)
    {
        $type=$request->type;
        $pid=$request->pid;
        $data=[
            'name'=>$request->name,
            'pid'=>$request->pid,
            'type'=>$type
        ];
        if($type=='click'){
            $data['key']=$request->key;
        }else{
            $data['url']=$request->key;
        }
        $num=Menu::where('pid',0)->count();
        if($num>3){
            echo '一级菜单最大3个';die;
        }
        $sonnum=Menu::where('pid',$pid)->count();
        if($sonnum>5){
            echo '二级菜单最大5个';die;
        }
        $re=Menu::insert($data);
        if($re){
            echo '添加成功';
        }else{
            echo '添加失败';
        }
    }

    public function menuadddo()
    {
        $arr=Menu::where('pid',0)->get()->toarray();
        $data=[];
        foreach ($arr as $k=>$v){
            $data[$k]['name']=$v['name'];
            if(empty($v['type'])){
                $sonarr=Menu::where('pid',$v['m_id'])->get()->toarray();
                foreach ($sonarr as $key=>$val){
                    if($val['type']=='click'){
                        $data[$k]['sub_button'][]=[
                            'name'=>$val['name'],
                            'type'=>$val['type'],
                            'key'=>$val['key'],
                        ];
                    }else{
                        $data[$k]['sub_button'][]=[
                            'name'=>$val['name'],
                            'type'=>$val['type'],
                            'url'=>$val['url'],
                        ];
                    }
                }
            }else{
                $data[$k]['type']=$v['type'];
                if($v['type']=='click'){
                    $data[$k]['key']=$v['key'];
                }else{
                    $data[$k]['url']=$v['url'];
                }
            }
        }
        print_r($data);die;
//        foreach ($arr as $k=>$v){
//            unset($arr[$k]['status']);
//            if($v['pid']==0){
//                $data[]=$v;
//            }
//        }
//        foreach ($data as $k=>$v){
//            foreach ($arr as $key=>$val){
//                if($v['m_id']==$val['pid']){
//                    $data[$k]['sub_button'][]=$val;
//
//                }
//                if(empty($v['type'])){
//                    unset($data[$k]['type']);
//                    unset($data[$k]['url']);
//                    unset($data[$k]['key']);
//                }else if($v['type']=='click'){
//                    unset($data[$k]['url']);
//                }else if($v['type']=='view'){
//                    unset($data[$k]['key']);
//                }
//                unset($data[$k]['m_id']);
//                unset($data[$k]['status']);
//                unset($data[$k]['pid']);
//            }
//        }
        print_r($data);
    }

}
