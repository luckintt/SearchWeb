<?php
echo "<center>";

include_once ("configue.php");
include_once ("functions.php");
include_once ("common.php");

//print_r($_GET);
$link=connectdb();
if(isset($_GET["dname"]) &&  isset($_GET["address"]) &&  isset($_GET["pname"]) && isset($_GET['pic'])  && isset($_GET['user'])) {
    $dname = $_GET["dname"];
    $address = $_GET["address"];
    $pname = $_GET["pname"];
    $pic = $_GET['pic'];
    $user = $_GET['user'];

    if(strcmp($_COOKIE["username"],$user)==0 || $_COOKIE["utype"]==2){
        //获取要删除的主码并拼装删除sql，执行
        $sql = "delete  from  词条 where  商店名='$dname'  and  地址='$address'  and  商品名='$pname'";
//    echo $sql;
        mysqli_query($link, $sql);
        //执行图片删除
        if (mysqli_affected_rows($link) > 0) {
            @unlink($pic);

            $sql1 = "update  用户  set  创建词条个数=创建词条个数-1  where  用户名='$user'";
            //               echo $sql1."<br>";
            mysqli_query($link, $sql1);
            if (mysqli_affected_rows($link) > 0) {
                echo "<h2>用户创建词条个数更新成功</h2>";
            } else {
                echo "用户创建词条个数更新失败<br>";
            }
            echo "<h2>词条删除成功</h2>";
        } else {
            echo "<h2>词条删除失败</h2>".mysqli_error($link);;
        }
    }else{
        echo "<h2>该词条是另一个用户创建，您无法执行删除！</h2>";
    }
}else {
    echo "未获取到要删除的词条信息！";
}

echo "<a href='javascript:window.history.back()'>返回</a>";
echo "&nbsp;&nbsp;&nbsp";
echo "<a href='allresult.php?type=0'>浏览词条信息</a>";
mysqli_close($link);
echo "</center>";
?>