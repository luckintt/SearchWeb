<?php

header("Content-type:text/html;charset=utf-8");

require_once 'functions.php';
$conn=connectdb();

if(@$_COOKIE['login']){
    $username = $_COOKIE["username"];

    setcookie("username");
    setcookie("uid", time() - 3600);
    setcookie("utype", time() - 3600);
    setcookie("islogin", false);
    setcookie("count",time()-3600);
}
//print_r($_POST);

//$username=$_POST['UserName'];
$type=$_GET['type'];
$pw=md5($_POST['PassWord']);
$username = isset($_POST['UserName'])?$_POST['UserName']:"username不存在";
$password = isset($pw)?$pw:"password不存在";

$result=mysqli_query($conn,"select  * from  用户  where  用户名='{$username}'  and  密码='$password'");
if(mysqli_errno($conn)){
    echo mysqli_error($conn);
}else{
    $dataCount=mysqli_num_rows($result);

//    echo "找到记录条数：$dataCount<br>";
    if($dataCount>0) {
        $row=$result->fetch_assoc();  //获取一行记录
        if($type==$row['类型']) {
            $time = time() + 60 * 60 * 24 * 7;  //保存一周
            setcookie("username", $_POST["UserName"], $time);
            setcookie("uid", $row["用户编号"], $time);
            setcookie("utype", $row["类型"], $time);
            setcookie("islogin", true, $time);
            setcookie("count", 0, $time);
//        echo "<script>alert('登录成功');location='http://www.baidu.com';</script>";
            header("Location:allresult.php?type=0");
        }else{
            if($type==0)
                echo "<script>alert('这不是用户登录的账号密码！！');location='login/login.html';</script>";
            else if($type==1)
                echo "<script>alert('这不是商家登录的账号密码！！');location='login/merchantlogin.html';</script>";
            else if($type==2)
                echo "<script>alert('这不是管理员登录的账号密码！！');location='login/managerlogin.html';</script>";
        }
    }else{
        if($type==0)
            echo "<script>alert('用户名或密码错误！！！');location='login/login.html';</script>";
        else if($type==1)
            echo "<script>alert('用户名或密码错误！！！');location='login/merchantlogin.html';</script>";
        else if($type==2)
            echo "<script>alert('用户名或密码错误！！！');location='login/managerlogin.html';</script>";
//       header("Location:login/login.html");
    }
}
