<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkpwd;
use Illuminate\Http\Request;
use App\Model\User;
use App\Tools\Captcha;

class LoginController extends Controller
{
    //登录视图
    public function login(Request $request)
    {
        $info=$request->post();
//        ;die;
        if(empty($info)){
            return view('login');
        }else{
//            var_dump($info);die;
            if($info['code']==session('code')){
                $arr=User::where('u_name',$info['u_name'])->first();
                if(!empty($arr)){
                    if($info['u_pwd']==decrypt($arr['u_pwd'])){
                        session(['u_id'=>$arr['u_id'],'username'=>$arr['u_name']]);
                        echo 1;
                    }else{
                        echo '账号或密码错误';
                    }
                }else{
                    echo '账号或密码错误';
                }
            }else{
                echo '验证码错误';
            }
        }
    }


    //注册
    public function register()
    {
//        return view('register');
//        return view('regauth');
        return view('registerpro');
    }

    //注册执行
    public function registerDo(CheckForm $request)
    {
        $request->validated();
        //验证短信验证码
        if(session('code')!=$request->code){
            echo '验证码错误,请重新输入';die;
        }

        $u_name=$request->u_name;
        //验证手机号码是否一致
        if(session('mobile')!=$u_name){
            echo '手机号与验证码不匹配';die;
        }
        $user=new User();
        //接收数据
        $user->u_name=$u_name;
        $user->u_pwd=encrypt($request->u_pwd);
        $res=$user->save();
//        获取保存的id
        $u_id=$user->u_id;
        if($res){
            session(['u_id'=>$u_id,'username'=>$u_name]);
            echo 1;
        }else{
            echo '注册失败';
        }
    }

    //个人中心
    public function userpage()
    {
        $unlogin='';
        if(empty(session('u_id'))){
            $unlogin='no';
        }
        return view('userpage',['unlogin'=>$unlogin]);

    }

    public function sendcode(Request $request)
    {
//        echo 1;die;
        $mobile=$request->mobile;
        $this->sendMobile($mobile);
    }

    //发送验证码
    private function sendMobile($mobile)
    {
        $host = env("MOBILE_HOST");
        $path = env("MOBILE_PATH");
        $method = "POST";
        $appcode = env("MOBILE_APPCODE");
        $headers = array();
        $code=createCode(4);
        session(['code'=>$code,'mobile'=>$mobile]);
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "content=【创信】你的验证码是：".$code."，3分钟内有效！&mobile=".$mobile;
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));
    }

    //找回密码
    public function findpwd()
    {
        return view('findpwd');
    }

    public function next(Request $request)
    {
        $tel=$request->tel;
        $code=$request->code;
        if($tel==session('mobile')&&$code==session('code')){
            return 1;
        }else{
            return 2;
        }
    }

    //修改密码试图
    public function loginpwd(Request $request)
    {
        $info=$request->post();
        if(empty($info)){
            return view('mody-loginpwd');
        }else{
//            var_dump($info);die;
//            echo session('u_id');die;
            $u_pwd=User::where('u_name',session('mobile'))->first(['u_pwd']);
            $u_pwd= decrypt($u_pwd['u_pwd']);
            if($u_pwd!=$info['nowpwd']){
                return '原密码错误';
            }
            $res=User::where('u_name',session('mobile'))->update(['u_pwd'=>encrypt($info['u_pwd'])]);
            if($res){
                return 1;
            }else{
                return '修改失败';
            }

        }
    }
}
