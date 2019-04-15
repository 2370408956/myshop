<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Wechat;
use CURLFile;
use App\Model\Substribe;
class SubstribeController extends Controller
{
    public function index()
    {
        $type=config('wxconfig.subscribe');
        return view('index.index',['type'=>$type]);
    }

    /**
     * 添加执行
     * @param Request $request
     */
    public function indexdo(Request $request)
    {
        if($request->hasFile('file')){
            $file=$request->file;
            $data=Wechat::uploads($file);
//            var_dump($data);die;
            $imgpath=$data['imgpath'];
            $type=$data['type'];
            $token=Wechat::getAccess_token();
//            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
            $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
            $re=Wechat::HttpPost($url,['media'=>new CURLFile(realpath($imgpath))]);
            $info=json_decode($re,true);
//            echo 1;die;v
//            var_dump($re);
        }
        $data=[
            'type'=>$request->input('type',null),
            'title'=>$request->input('title',null),
            'intro'=>$request->input('title',null),
            'madia_id'=>isset($info['media_id'])?$info['media_id']:null,
            'url'=>$request->input('s_url',null),
            'pic_url'=>isset($info['url'])?$info['url']:null,
        ];
        $re=Substribe::insert($data);
        if($re){
            echo '添加成功';
        }else{
            echo '添加失败';
        }
    }

    public function wetype()
    {
        $type=config('wxconfig.subscribe');
        return view('admin.wetype',['type'=>$type]);
    }

    public function wetypedo(Request $request)
    {
        $type=$request->type;
        $config=[];
        $config['subscribe']=$type;
        $config_path=config_path().'/wxconfig.php';
        $str="<?php return ".var_export($config,true).';?>';
        $re=file_put_contents($config_path,$str);
        return $re;
    }
}
