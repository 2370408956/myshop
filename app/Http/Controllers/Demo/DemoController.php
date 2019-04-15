<?php

namespace App\Http\Controllers\Demo;

use App\Model\Wechat;
use App\Model\Wx;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    //保存token
    public function index()
    {
        $path=public_path().'/wx/token.txt';
        $info=file_get_contents($path);
        if(empty($info)){
            $token=$this->access_token();
            $time=time()+7000;
            $info=['token'=>$token,'time'=>$time];
            $info=json_encode($info);
            file_put_contents($path,$info);
            return $token;
        }else{
            $data=json_decode($info,true);
            if(time()>$data['time']){
                $token=$this->access_token();
                $time=time()+7000;
                $info=['token'=>$token,'time'=>$time];
                $info=json_encode($info);
                file_put_contents($path,$info);
                return $token;
            }else{
                return $data['token'];
            }
        }
//        $app_id=env('APPID');
//        $secret=env('SECRET');
//        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$app_id&secret=$secret";
//        $token=file_get_contents($url);
        $token='{"access_token":"20_ltWKjxdH244bNyvUAWoJWtN9iSKIDaSLj5oxTtd5Xvw_sqYHfPu11SAWD-jpJIIDIfn9SpXjZl_hVOblQuiQZMke8W6RmtK8q1U_9bFKSr05VcuWMb6Hcdy53ki01yavYFttHdxhWK6BrNr1SRTfAIAEDF","expires_in":7200}';
        $token=json_decode($token,true);
        print_r($token['access_token']);
    }

    //返回token
    public function access_token()
    {
        $app_id=env('APPID');
        $secret=env('SECRET');
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$app_id&secret=$secret";
        $token=file_get_contents($url);
        $token=json_decode($token,true);
        return $token['access_token'];
    }

    public function check()
    {
//        $echostr=$_GET['echostr'];
//        if($this->checkstr()){
//            return $echostr;
//            exit;
//        }else{
//            return false;
//        }
        $this->responseMsg();
    }

    public function checkstr()
    {
        $signature=$_GET["signature"];
        $timestamp=$_GET["timestamp"];
        $token=env('WECHATTOKEN');
        $nonce=$_GET["nonce"];

        $tmpArr = array($token,$timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $signature==$tmpStr){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = file_get_contents("php://input");
        //extract post data
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textstr='<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                      </xml>';
            if($postObj->MsgType=='event'){
                if($postObj->Event=='subscribe'){
                    $token=$this->index();
                    $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$fromUsername&lang=zh_CN";
                    $info=file_get_contents($url);
                    $msgType='text';
                    $contentStr='你好';
                    $info=json_decode($info,true);
                    $data=[
                        'w_name'=>$info['nickname'],
                        'w_sex'=>$info['sex'],
                        'w_city'=>$info['city'],
                        'w_province'=>$info['province'],
                        'w_country'=>$info['country']
                    ];
                    Wx::insert($data);
                    $resultStr = sprintf($textstr, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }
        }
    }

    public function addmenu()
    {
        $menu='{
         "button":[
         {    
              "type":"click",
              "name":"今日歌曲",
              "key":"V1001_TODAY_MUSIC"
          },
          {
               "name":"菜单",
               "sub_button":[
               {    
                   "type":"view",
                   "name":"搜索",
                   "url":"http://www.soso.com/"
                },
                {
                     "type":"miniprogram",
                     "name":"wxa",
                     "url":"http://mp.weixin.qq.com",
                     "appid":"wx286b93c14bbf93aa",
                     "pagepath":"pages/lunar/index"
                 },
                {
                   "type":"click",
                   "name":"赞一下我们",
                   "key":"V1001_GOOD"
                }]
           }]
     }';
      $token=$this->access_token();
      $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
      $re=Wechat::HttpPost($url,$menu);
      var_dump($re);
    }
    public function indexadd()
    {
        return view('demo.indexadd');
    }
}
