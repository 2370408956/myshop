<?php

namespace App\Model;
use Illuminate\Support\Facades\Storage;
use App\Model\Substribe;
use App\Model\Goods;
class Wechat
{
    //curl模拟post请求
    public static function HttpPost($url,$post_data='')
    {
        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }


    //curl模拟get
    public static function HttpGet($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }

    /**
     * @param $keyword  用户输入的城市+天气
     * @return string  城市天气信息
     */
    public static function getCityWeather($keyword)
    {
        $city=substr($keyword,0,strpos($keyword,'天气'));
        $url = "http://api.k780.com/?app=weather.today&weaid=$city&appkey=".env('WEATHER_APPKEY').'&sign='.env('WEATHER_SIGN')."&format=json";
        $res=file_get_contents($url);
        $res=json_decode($res,true);
        if($res['success']==1){
            $contentStr=$res['result']['citynm'].'：'.$res['result']['days'].','.$res['result']['weather'].'  '.$res['result']['wind'].$res['result']['winp'].'最低气温'.$res['result']['temp_low'].'度'.'，'.'最高温度'.$res['result']['temp_high'].'度';
        }else{
            $contentStr='好像输错了，要不输入北京天气试试';
        }

        return $contentStr;
    }

    /**
     * @param $keyword 用户输入的信息
     * @return mixed   机器人回复的消息
     */
    public static function tuling($keyword)
    {
        $data=[
            'perception'=>[
                'inputText'=>[
                    'text'=>$keyword
                ]
            ],
            'userInfo'=>[
                'apiKey'=>env("TULING_APIKEY"),
                'userId'=>env("TULING_USERID")
            ]
        ];
        $data=json_encode($data);
        $tulingurl='http://openapi.tuling123.com/openapi/api/v2';
        $re=self::HttpPost($tulingurl,$data);
        $contentStr=json_decode($re,true)['results'][0]['values']['text'];

        return $contentStr;
    }


    /**
     * @return mixed 返回access_token
     */
    public static function getAccess_token()
    {

        $filename=public_path().'/wx/access_token.txt';
        $token=file_get_contents($filename);
        if(empty($token)){
            $re=self::requestToken();
            $arr=['token'=>$re,'time'=>time()+7000];
            $arr=json_encode($arr);
            file_put_contents($filename,$arr);
        }else{
            $arr=json_decode($token,true);
            if(time()>$arr['time']){
                $re=self::requestToken();
                $arr=['token'=>$re,'time'=>time()+7000];
                $arr=json_encode($arr);
                file_put_contents($filename,$arr);
            }else{
                $re=$arr['token'];
            }
        }
        return $re;
    }

    /**
     * @return mixed  返回access_token
     */
    public static function requestToken()
    {
        $appid=env('APPID');
        $secret=env('SECRET');
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $re=file_get_contents($url);
        $re=json_decode($re,true);
        return $re['access_token'];
    }

    /**
     * @param $str  文件的mime类型,和文件后缀名
     * @return mixed  返回type类型
     */
    public static function getType($str)
    {
        $data=explode('/',$str);
        $arr=[
            'image'=>'image',
            'audio'=>'voice',
            'video'=>'video'
        ];
        return $arr[$data[0]];
    }


    public static function uploads($file)
    {
        $ext=$file->getClientOriginalExtension();
        //获取临时路径
        $path=$file->getRealPath();
        //获取文件类型
        $type=$file->getClientMimeType();
        $type=self::getType($type);
        //生成新名字
        $filename=date('Ymd').'/'.mt_rand(1111,9999).'.'.$ext;
        $res=Storage::disk('uploads')->put($filename,file_get_contents($path));
        $imgpath=public_path().'/uploads/'.$filename;
        $date=['imgpath'=>$imgpath,'type'=>$type];
        if($res){
            return $date;
        }else{
            return false;
        }
    }

    public static function emptyclear()
    {
        $app_id=env('APPID');
        $token=self::getAccess_token();
        $url="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=$token";
        $re=self::HttpPost($url,"{appid:$app_id}");
        var_dump($re);
    }

    public static function wxnews($type,$fromUsername,$toUsername)
    {
        $text="<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <ArticleCount>1</ArticleCount>
                  <Articles>
                    <item>
                      <Title><![CDATA[%s]]></Title>
                      <Description><![CDATA[%s]]></Description>
                      <PicUrl><![CDATA[%s]]></PicUrl>
                      <Url><![CDATA[%s]]></Url>
                    </item>
                  </Articles>
               </xml>";
        $msgType = "news";
        $time=time();
        $info=Substribe::where('type',$type)->OrderBy('s_id','desc')->first();
        $Title=$info->title;
        $Description=$info->intro;
        $PicUrl=$info->pic_url;
        $url=$info->url;
        $resultStr = sprintf($text, $fromUsername, $toUsername, $time, $msgType, $Title,$Description,$PicUrl,$url);
        return $resultStr;
    }

    public static function wximage($type,$fromUsername,$toUsername)
    {
        $text='<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                  </Image>
               </xml>';
        $msgType='image';
        $time=time();
        $madia_id=Substribe::where('type',$type)->OrderBy('s_id','desc')->first('madia_id');
//        $madia_id='fpHzJkNz-1BRd1rNYFJGqCaqqKd4ZeTQ2zYSnr3s3AZWgcnocTWJO4L065wQThrb';
        $resultStr = sprintf($text, $fromUsername, $toUsername, $time, $msgType,$madia_id );
        return $resultStr;
    }


    public static function wxvideo($type,$fromUsername,$toUsername)
    {
        $text="<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                  </Video>
               </xml>";
        $msgType='video';
        $time=time();
        $resultStr = sprintf($text, $fromUsername, $toUsername, $time, $msgType);
        return $resultStr;
    }

    public static function getGoods($keyword)
    {
        $re=Goods::where('goods_name','like',"%$keyword%")->first(['goods_id']);
//        return $re;
        $goods_id=$re->goods_id;
        if($re){
            $str="http://39.96.198.239/goods/shopcontent/$goods_id";
        }else{
            $str=false;
        }
        return $str;
    }
}