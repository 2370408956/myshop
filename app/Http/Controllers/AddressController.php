<?php

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AddressController extends Controller
{
    //地址视图
    public function address()
    {
        $addressinfo=Address::where('u_id',session('u_id'))
            ->get();
        $areainfo=Area::get();
        foreach($areainfo as $v){
            foreach($addressinfo as $val){
                if($val['province']==$v['id']){
                    $val['province']=$v['name'];
                }
                if($val['city']==$v['id']){
                    $val['city']=$v['name'];
                }
                if($val['county']==$v['id']){
                    $val['county']=$v['name'];
                }
            }
        }
        return view('address',['addressinfo'=>$addressinfo]);
    }

    //添加地址视图
    public function addaddress()
    {
        $area=Area::where('pid',0)->get();
        return view('writeaddr',['area'=>$area]);
    }

    //修改视图
    public function addressedit($address_id)
    {
        $where=[
            'u_id'=>session('u_id'),
            'address_id'=>$address_id
        ];
        $area=Area::where('pid',0)->get();
        $addressinfo=Address::where($where)->first();
        $areainfo=Area::get();
        $city=[];
        $county=[];
        foreach ($areainfo as $v){
            if($v['pid']==$addressinfo['province']){
                $city[]=$v;
            }
            if($v['pid']==$addressinfo['city']){
                $county[]=$v;
            }
        }
        return view('addressedit',['addressinfo'=>$addressinfo,'area'=>$area,'city'=>$city,'county'=>$county]);
    }

    //修改执行
    public function addressupdate(Request $request)
    {
        $info=$request->obj;
        unset($info['_token']);
        DB::beginTransaction();
        if($info['is_default']==1){
            $res1=Address::where('u_id',session('u_id'))->update(['is_default'=>2]);
            $res=Address::where(['u_id'=>session('u_id'),'address_id'=>$info['address_id']])->update($info);
            if($res1!==false && $res){
                DB::commit();
                return 1;
            }else{
                DB::rollback();
                return 2;
            }
        }else{
            $res=Address::where(['u_id'=>session('u_id'),'address_id'=>$info['address_id']])->update($info);
            if($res!==false){
                DB::commit();
                return 1;
            }else{
                DB::rollback();
                return 2;
            }
        }
    }
    //添加地址执行
    public function addressdo(Request $request)
    {
        $info=$request->obj;
        unset($info['_token']);
        $info['u_id']=session('u_id');
        DB::beginTransaction();
        if($info['is_default']==1){
            $res1=Address::where('u_id',session('u_id'))->update(['is_default'=>2]);
            $res=Address::insert($info);
            if($res!==false && $res1){
                DB::commit();
                return 1;
            }else{
                DB::rollback();
                return 2;
            }
        }else{
            $res=Address::insert($info);
            DB::commit();
            if($res){
                return 1;
            }else{
                return 2;
            }
        }
    }

    //设为默认
    public function adddefault(Request $request)
    {
        $address_id=$request->address_id;
        DB::beginTransaction();
        $where=[
            'u_id'=>session('u_id'),
            'address_id'=>$address_id
        ];
//        var_dump($where);die;
//        echo session('u_id');die;
       $address=new Address();
        $res1=$address->where('u_id',session('u_id'))->update(['is_default'=>2]);

        $res=$address->where($where)->update(['is_default'=>1]);
        if($res&&$res1!==false){
            DB::commit();
            return 1;
        }else{
            return 2;
            DB::rollback();
        }
    }

    //删除地址
    public function addressdel(Request $request)
    {
        $address_id=$request->address_id;
        $res=Address::where('address_id',$address_id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    //三级联动
    public function addressarea(Request $request)
    {
        $id=$request->id;
        $areainfo=Area::where('pid',$id)->get();
        return json_encode($areainfo);
    }

}
