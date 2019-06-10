<?php

header("Content-type:text/html;charset=utf-8");

require_once 'functions.php';
$link=connectdb();
$type=$_GET['type'];
if($_COOKIE['utype']!=2  &&isset($_COOKIE["username"])){
    echo "<center>";
    echo "您还没有退出登录！<br>";
    echo "<a href='javascript:window.history.back()'>返回</a>";
    echo "&nbsp;&nbsp;&nbsp";
    echo "<a href='signout.php'>注销账号</a>";
    echo "</center>";
}
else {
//$username=$_POST['UserName'];
    $pw = md5($_POST['PassWord']);
//$pic=$_POST['pic'];
    $username = isset($_POST['UserName']) ? $_POST['UserName'] : "username不存在";
    $password = isset($pw) ? $pw : "password不存在";

    $result = mysqli_query($link, "select  * from  用户  where  用户名='{$username}'");
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo "<center>";
        $dataCount = mysqli_num_rows($result);
//    echo "找到记录条数：$dataCount<br>";
        if ($dataCount > 0) {
//        echo "<script>alert('登录成功');location='http://www.baidu.com';</script>";
            echo "该用户名已经存在！<br>";
            echo "<a href='login/signup.html'>重新注册</a>";
        } else {
            //使用默认图片执行图片上传
            $pic = './login/img/01.jpg';

            //4.执行图片缩放
//        imageUpdateSize("./uploads/".$pic,50,50);

            //5.拼装sql语句，并执行添加
            $sql = "insert  into  用户(用户名,密码,用户头像,类型)  values  ('{$username}','{$password}','$pic','$type')";
//        echo $sql."<br>";
            mysqli_query($link, $sql);

            //6.判断并输出结果
            if (mysqli_affected_rows($link) > 0) {
                echo "注册成功！<br>";
                echo "<a href='login/login.html'>登录</a>";
            } else {
                echo "注册失败！" . mysqli_error($link);
            }
        }

//        echo "&nbsp;&nbsp;&nbsp";
//        echo "<a href='allresult.php'>浏览词条信息</a>";
        echo "</center>";
    }

}