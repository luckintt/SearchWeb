<?php
echo "<center>";

include_once ("configue.php");
include_once ("functions.php");
include_once ("common.php");

//print_r($_GET);
$link=connectdb();
if(isset($_GET["name"])&& isset($_GET['address'])) {
    $name=$_GET["name"];
    $address=$_GET['address'];
    $sql="delete  from  商家 where  商店名='$name'  and  地址='$address'";
//    echo $sql;
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)){
        echo "<h2>删除成功</h2>";
    }else{
        echo "<h2>删除失败</h2>".mysqli_error($link);
    }
} else {
    echo "未获取到要删除的商家信息！";
}
echo "<a href='javascript:window.history.back()'>返回</a>";
echo "&nbsp;&nbsp;&nbsp";
echo "<a href='showshangjia.php'>浏览商家信息</a>";
mysqli_close($link);
echo "</center>";
?>