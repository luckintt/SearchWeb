<?php
echo "<center>";

include_once ("configue.php");
include_once ("functions.php");
include_once ("common.php");

//print_r($_GET);
$link=connectdb();
if(isset($_GET["name"]) && isset($_GET['pic'])) {
     $name=$_GET["name"];
     $pic=$_GET['pic'];
     $sql1="select  *  from  销售 where 销售.商品名='$name'";
     $result1=mysqli_query($link,$sql1);
     $dateCount=mysqli_num_rows($result1);
     if($dateCount>0){
         echo "<h2>该商品有对应的销售记录存在，无法删除！</h2>";
     }else {
         //4.解析商品信息（解析结果集）

         $sql = "delete  from  商品  where  商品名='$name'";
         //    echo $sql;
         mysqli_query($link, $sql);

         if (mysqli_affected_rows($link)) {
             //执行图片删除
             if (mysqli_affected_rows($link) > 0) {
                 @unlink($pic);
             }
             echo "<h2>删除成功</h2>";
         } else {
             echo "<h2>删除失败</h2>" . mysqli_error($link);
         }
     }
}else{
     echo "未获取到要删除的商品信息！";
}
echo "<a href='javascript:window.history.back()'>返回</a>";
echo "&nbsp;&nbsp;&nbsp";
echo "<a href='showshangpin.php?type=0'>浏览商品信息</a>";
mysqli_close($link);

echo "</center>";
?>

