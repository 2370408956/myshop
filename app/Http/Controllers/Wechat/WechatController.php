<?php
namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Substribe;
class WechatController extends Controller
{
    public function checksign()
    {
//        $echostr=$_GET['echostr'];
//        if($this->wechat()){
//            return $echostr;exit;
//        }

        $this->responseMsg();
    }

    /**
     * @content 微信校验
     * @return bool
     */
    private function wechat()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = env('WECHATTOKEN');
        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpArr = implode($tmpArr);
        $tmpArr = sha1($tmpArr);
        if ($tmpArr == $signature) {
            return true;
        } else {
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
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                        </xml>";
            if ($postObj->MsgType == "event") {
                if ($postObj->Event == "subscribe") {
                    $type=config('wxconfig.subscribe');
                    $wxtype='wx'.$type;
                    $resultStr=Wechat::$wxtype($type,$fromUsername,$toUsername);
                    echo $resultStr;
                }
            }

            if(strstr($keyword,'商品')){
                $keyword=substr($keyword,6,strlen($keyword));
                $re=Wechat::getGoods($keyword);
                $msgType = "text";
                $contentStr = $re;
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else if($keyword=='你好'){
                //关键词回复
                $msgType = "text";
                $contentStr = "不太好";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }elseif($keyword=='图片'){
                $textTpl="<xml>
                              <ToUserName><![CDATA[%s]]></ToUserName>
                              <FromUserName><![CDATA[%s]]></FromUserName>
                              <CreateTime>%s</CreateTime>
                              <MsgType><![CDATA[%s]]></MsgType>
                              <Image>
                                <MediaId><![CDATA[%s]]></MediaId>
                              </Image>
                          </xml>";
                $msgType='image';
                $media_id='fpHzJkNz-1BRd1rNYFJGqCaqqKd4ZeTQ2zYSnr3s3AZWgcnocTWJO4L065wQThrb';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $media_id);
                echo $resultStr;
            }elseif($keyword=='大人物'){
                $textTpl="<xml>
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
                $msgType='news';
                $Title='小游戏';
                $Description='好玩';
                $PicUrl=url('/uploads/20190408/1238.png');
                $url='http://www.4399.com/';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $Title,$Description,$PicUrl,$url);
                echo $resultStr;
            }else if(strpos($keyword,'天气')){
                //城市天气
                $contentStr=Wechat::getCityWeather($keyword);
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                //小机器人
                $contentStr=Wechat::tuling($keyword);
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
        }
    }
}