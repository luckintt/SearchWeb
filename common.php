<?php
echo "<center>";
//print_r($_COOKIE);
if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
    include_once  "usermenu.php";
}else{
    include_once  "menu.php"; //导入导航栏
}
if(!@$_COOKIE["islogin"]){
//    header("Location:login/login.html");
//    echo "<script>alert('登录之后才能进行此操作！确定跳转到登录界面？');location='login/login.html';</script>";
    echo "<h3>登录之后才能进行此操作！确定跳转到登录界面？</h3>";
    echo "<a href='javascript:window.history.back()'>返回</a>";
    echo "&nbsp;&nbsp;&nbsp";
    echo "<a href='login/login.html'>登录</a>";
    die("");
}
echo "</center>";