<?php
/**
 * Created by PhpStorm.
 * User: 小川
 * Date: 2019/3/16
 * Time: 15:49
 */


function soncateinfo($cateinfo,$cate_id)
{
    static $arr=[];
    foreach($cateinfo as $v){
        if($v['pid']==$cate_id){
            $arr[]=$v['cate_id'];
            soncateinfo($cateinfo,$v['cate_id']);
        }
    }
    return $arr;
}

//生成4位随机短信验证码
function createCode($num){
    $code='';
    for($i=1;$i<=$num;$i++){
        $code.=mt_rand(0,9);
    }
    return $code;
}

function successly($str)
{
    $arr=[
        'str'=>$str,
        'code'=>1
    ];
    echo json_encode($arr);
}


function error($str)
{
    $arr=[
        'str'=>$str,
        'code'=>2
    ];
    echo json_encode($arr);
}

//获取订单号
function getorderno(){
    return time().session('u_id').rand(100,999);
}

//发送邮箱
function sendCode($email,$code){
    //实例化PHPMailer核心类
    $mail = new App\Tools\email\PHPMailer;
    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    $mail->SMTPDebug =0;

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;

    //链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.163.com';//163邮箱：smtp.163.com

    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';//163邮箱就注释

    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = 465;//163邮箱：25

    //设置smtp的helo消息头 这个可有可无 内容任意
    // $mail->Helo = 'Hello smtp.qq.com Server';

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    //$mail->Hostname = 'http://localhost/';

    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = 'UTF-8';

    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = '川川哥哥';

    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username ='18434473747@163.com';

    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
    $mail->Password = '1426879qin';//163邮箱也有授权码 进入163邮箱帐号获取

    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = '18434473747@163.com';

    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true);

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($email);

    //添加多个收件人 则多次调用方法即可
    // $mail->addAddress('xxx@163.com','爱代码，爱生活世界');

    //添加该邮件的主题
    $mail->Subject = '欢迎你加入';

    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = 'http://localhost/month4/shop/public/index.php/login/updatePwd.html?email='.$code.',五分钟之内有效';

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    $status = $mail->send();

    //简单的判断与提示信息
    if($status) {
        return true;
    }else{
        return false;
    }
}
