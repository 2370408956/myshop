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
