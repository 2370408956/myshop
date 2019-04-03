<?php

namespace App\Http\Controllers\Demo;

use App\Model\Username;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    //发送验证码
    public function sendcode(Request $request)
    {
        $user_name=$request->user_name;
        $code=rand(1111,9999);
        $re=sendCode($user_name,$code);
        if($re){
            session(['code'=>$code,'time'=>time()]);
            return 1;
        }else{
            return 2;
        }
    }


    public function useradd(Request $request)
    {
        $code=$request->_code;
        $user_pwd=$request->user_pwd;
        $user_pwd1=$request->user_pwd1;
        if($code!=session('code')){
            return '验证码错误';
        }else if(time()-session('time')>120){
            return '验证码过期';
        }
        if($user_pwd!=$user_pwd1){
            return '2次密码不一致';
        }

        $username=new Username();
        $username->user_name=$request->user_name;
        $username->username=$request->username;
        $username->user_pwd=encrypt($request->user_pwd);
        $username->code=session('code');
        $re=$username->save();
        if($re){
            return 1;
        }else{
            return '注册失败';
        }

    }

    public function login()
    {
        return view('demo.login');
    }

    //注册执行
    public function logindo(Request $request)
    {
        $user_name=$request->user_name;
        $user_pwd=$request->user_pwd;
        $info=Username::where('user_name',$user_name)->first();
        if(!empty($info)){
            if($user_pwd==decrypt($info['user_pwd'])){
                if($info['error_num']>=5&&time()-$info['last_error']<3600){
                    $time=60-ceil((time()-$info['last_error'])/60);
                    echo '账号已被锁定,请'.$time.'分钟后再试';
                }else{
                    $info->last_error=null;
                    $info->error_num=0;
                    $re=$info->save();
                    echo '登录成功';
                    session(['u_id'=>$info['u_id']]);
                    Redis::set($info['u_id'],serialize($info));
                    return redirect('userlist');
                }
            }else{
                if($info['error_num']>=5&&time()-$info['last_error']>3600){
                    $info->last_error=time();
                    $info->error_num=1;
                    $re=$info->save();
                    echo '账号或密码错误';
                }else{
                    if($info['error_num']>=5&&time()-$info['last_error']<3600){
                        $time=60-ceil((time()-$info['last_error'])/60);
                        echo '账号已被锁定,请'.$time.'分钟后再试';
                    }else{
                        $error_num=$info['error_num'];
                        $info->last_error=time();
                        $info->error_num=$error_num+1;
                        $re=$info->save();
                        echo '账号或密码错误';
                    }
                }
            }
        }else{
            echo '账号不存在';
        }
    }


    public function userlist()
    {
        $data=unserialize(Redis::get(session('u_id')));
        return view('demo.userlist',['user_name'=>$data]);
    }
}
