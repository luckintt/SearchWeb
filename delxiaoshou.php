<?php
echo "<center>";

include_once ("configue.php");
include_once ("functions.php");
include_once ("common.php");

//print_r($_GET);
$link=connectdb();
if(isset($_GET["dname"]) && isset($_GET['address']) &&isset($_GET['pname'])) {
    $dname=$_GET["dname"];
    $address=$_GET['address'];
    $pname=$_GET['pname'];
    //获取要删除的主码并拼装删除sql，执行
    $sql="delete  from  销售  where  商店名='$dname'  and  地址='$address'  and  商品名='$pname'";
//        echo $sql;
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
echo " <a href='showxiaoshou.php'>浏览销售信息</a>";
mysqli_close($link);

echo "</center>";
?>