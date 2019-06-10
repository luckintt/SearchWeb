<?php
/**
 * Created by PhpStorm.
 * Op: Lucky123
 * Date: 2016/7/24
 * Time: 15:50
 */

require_once 'configue.php';

function connectdb(){
    $conn=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW);
    if(!$conn){
        die('Can  not  connect  db');
    }
    mysqli_select_db($conn,'mytest');
    return  $conn;
}

//公共函数库

/**
 * 文件上传处理函数
 * @param  string  filename  要上传的文件表单项名
 * @param  string  $path  上传文件的保存路径
 * @param  array  允许的文件类型
 * @return  array  二个单元：["error"]false:失败，true:成功
 *                            ["info"]存放失败原因或成功的文件名
 */

function uploadFile($filename,$path,$typelist=null){
    //1.获取上传文件的名字
    $upfile=$_FILES[$filename];
    if(empty($typelist)){
        $typelist=array("image/jpeg","image/jpg","image/png","image/gif");  //允许的文件类型
    }
    // $path="upload3";  //指定上传文件的保存路径（相对的）
    $res=array("error"=>false);  //存放返回的结果

    //2.过滤上传文件的错误号
    if($upfile["error"]>0){
        //获取错误信息
        switch ($upfile["error"]){
            case 1:
                $res["info"]="上传文件超过了php.ini中upload_max_filesize选项限制的值。";
                break;
            case 2:
                $res["info"]="上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值。";
                break;
            case 3:
                $res["info"]="文件只有部分被上传。";
                break;
            case 4:
//                $res["info"]="没有文件上传，将使用默认图片。";
                $upinfo["error"]=true;
                break;
            case 6:
                $res["info"]="找不到临时文件夹。";
                break;
            case 7:
                $res["info"]="文件写入失败。";
                break;
        }
        return $res;
    }

    //3.本次文件大小的限制
    if($upfile["size"]>10000000){
        $res["info"]="上传文件大小超出限制!";
        return $res;
    }

    //4.类型的过滤
    if(!in_array($upfile["type"],$typelist)){
        $res["info"]="上传文件类型非法：".$upfile["type"];
        return $res;
    }

    //5.初始化下列信息（为图片产生一个随机的名字）
    $fileinfo=pathinfo($upfile["name"]); //解析上传文件名字
    do{
        $newfile=date("YmdHis").rand(1000,9999).".".$fileinfo["extension"];//随机产生一个文件名
    }while(file_exists($path.$newfile));

    //6.执行文件上传
    //判断是否是一个上传的文件
    if(is_uploaded_file($upfile["tmp_name"])){
        //执行文件上传（移动上传文件）
        if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
            //将上传成功后的文件名赋给返回数组
            $res["info"]=$newfile;
            $res["error"]=true;
            return $res;
        }else{
            $res["info"]="上传文件失败！";
        }
    }else{
        $res["info"]="不是一个上传文件！";
    }
    return  $res;
}
