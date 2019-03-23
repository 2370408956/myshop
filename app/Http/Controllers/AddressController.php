<?php

namespace App\Http\Controllers;

use App\Model\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AddressController extends Controller
{
    //地址视图
    public function address()
    {
        $addressinfo=Address::get();
        return view('address',['addressinfo'=>$addressinfo]);
    }

    //添加地址视图
    public function addaddress()
    {
        return view('writeaddr');
    }

    //修改视图
    public function addressedit($address_id)
    {
        $where=[
            'u_id'=>session('u_id'),
            'address_id'=>$address_id
        ];
        $addressinfo=Address::where($where)->first();
        return view('addressedit',['addressinfo'=>$addressinfo]);
    }

    //修改执行
    public function addressupdate(Request $request)
    {
        $info=$request->post();
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
            if($res){
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
        $info=$request->post();
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
        $res1=Address::where('u_id',session('u_id'))->update(['is_default'=>2]);
        $res=Address::where($where)->update(['is_default'=>1]);
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

}
