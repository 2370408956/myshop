<?php
namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use Illuminate\Http\Request;

use App\Model\Material;
class MaterialController extends Controller
{
    //上传素材
    public function index()
    {
        return view('wechat.index');
    }

    public function updo(Request $request)
    {
        if($request->hasFile('file')){
            $file=$request->file;
            //获取文件的扩展名
            $data=Wechat::uploads($file);
            $imgpath=$data['imgpath'];
            $type=$data['type'];
            $token=Wechat::getAccess_token();
            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
            $re=Wechat::HttpPost($url,['media'=>new \CURLFILE(realpath($imgpath))]);
            $re=json_decode($re,true);
            if(isset($re['errcode'])){
                var_dump($re['errmsg']);
            }else{
                $media_id=$re['media_id'];
                $material=new Material();
                $material->material_title=$request->material_title;
                $material->material_desc=$request->desc;
                $material->media_id=$media_id;
                $material->material_url=$request->url;
                $re=$material->save();
                if($re){
                    echo '添加成功';
                }else{
                    echo '添加失败';
                }
            }
        }
    }
}