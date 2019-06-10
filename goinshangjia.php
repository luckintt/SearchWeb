<!DOCTYPE html>
<html>

<head>
    <title>乐淘优选网</title>
    <script  type="text/javascript">
        function dodel(name){
            alert(name);
            if(confirm("确定要删除吗？")){
                window.location="action.php?action=delshangpin&商品名="+name;
            }
        }
    </script>
</head>
<style type="text/css">
    body{
        background: #F5F5F5;
        width: 100%;
        padding: 0;
        margin: 0;
    }
    .body{
        width: 75%;
        height: 50px;
        margin: 35px auto;
        margin-top: 85px;
        box-sizing: content-box;
        padding: 0;
        border: 0px;
        box-shadow: 1px 1px 5px 1px rgba(200, 200, 200, 1), -1px -1px 5px 1px rgba(200, 200, 200, 1);

    }

    .search{
        display: inline-block;
        width: 90%;
        height: 50px;
        margin: 0px;
        font-family: "楷体", "新宋体";
        font-size: 25px;
        text-indent: 10px;
        border: 0px;
        box-sizing: border-box;
        outline: none;
    }
    .searching{
        margin: 0px;
        display:inline-block;
        float: right;
        width: 10%;
        height: 50px;
        font-family: "楷体", "新宋体";
        font-size: 25px;
        background: rgba(66, 132, 223, 1);
        border: 0px;
        box-sizing: border-box;
        outline: none;
    }
    .searching:active{
        background: rgba(66, 132, 255, 1);
    }
    .all-result{
        width: 75%;
        margin: 0 auto;
    }
    .res-box{
        display:inline-block;
        margin: 15px 5px 10px 5px;
        width: 48%;
        background: #FFFFFF;
        height: 225px;
        box-sizing: border-box;
        box-sizing: content-box;
        box-shadow: 0px 0px 8px 1px rgba(200, 200, 200, 1);
    }
    .res-img{
        display: inline-block;
        width: 55%;
        height: 100%;
        box-sizing: border-box;
    }
    .res-info{
        display: inline-block;
        float: right;
        box-sizing: border-box;
        width: 45%;
        height: 100%;
        padding: 0;
        /*border: 1px solid blue;*/
    }
    .tar{
        font-family: "楷体", "新宋体";
        font-size: 18px;
        display: block;
        list-style-type: none;
        width: 100%;
        margin: 10px 0px 10px -30px;
        /*border: 1px solid greenyellow;*/
    }
    .res-xinxi{
        margin: 0;
    }
</style>
<body>
<center>
    <?php
    if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
        include_once  "usermenu.php";
    }else{
        include_once  "menu.php"; //导入导航栏
    }
    ?>
    <?php
    require_once("functions.php");
    echo "<h3>".$_GET['商店名']."的商品信息</h3>";
    echo "<a  href='goinshangjia.php?用户名={$_GET['用户名']}&商店名={$_GET['商店名']}&地址={$_GET['地址']}&type=1'>休闲零食</a> | ";
    echo "<a  href='goinshangjia.php?用户名={$_GET['用户名']}&商店名={$_GET['商店名']}&地址={$_GET['地址']}&type=2'>奶品水饮</a> | ";
    echo "<a  href='goinshangjia.php?用户名={$_GET['用户名']}&商店名={$_GET['商店名']}&地址={$_GET['地址']}&type=3'>生鲜水果</a> | ";
    echo "<a  href='goinshangjia.php?用户名={$_GET['用户名']}&商店名={$_GET['商店名']}&地址={$_GET['地址']}&type=4'>生活用品</a> | ";
    echo "<a  href='goinshangjia.php?用户名={$_GET['用户名']}&商店名={$_GET['商店名']}&地址={$_GET['地址']}&type=5'>新品推荐</a>";
    ?>
</center>
<?php
//从数据库中读取信息并输出到浏览器表格中
//1.导入配置文件
require_once ("configue.php");

//2.连接数据库，并选择数据库
$link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or die("数据库连接失败！");
mysqli_select_db($link,DBNAME);

$type=$_GET['type'];
$str="";
$sql="";

if($type>=1 && $type<5){
    if($type==1)
        $str="休闲零食";
    else if($type==2)
        $str="奶品水饮";
    else if($type==3)
        $str="生鲜水果";
    else
        $str="生活用品";
    $sql="select  商品.用户名,商品.商品名,商品.商标,商品.商品图片,商品.商品创建时间  from  商品,销售
            where  销售.商店名='{$_GET['商店名']}'  and  销售.地址='{$_GET['地址']}' and 商品.商品名=销售.商品名 and 商品.类型='{$str}' order by 商品名  ASC;";
    //   }
}else
    $sql="select  商品.用户名,商品.商品名,商品.商标,商品.商品图片,商品.商品创建时间  from  商品,销售  
            where  销售.商店名='{$_GET['商店名']}'  and  销售.地址='{$_GET['地址']}' and 商品.商品名=销售.商品名  order by 商品名  ASC";

//3.执行商家商品信息查询
$result=mysqli_query($link,$sql);
$dateCount=mysqli_num_rows($result);
if($dateCount<=0 && $type!=5){
    echo "<center>";
    echo "<h3>还没有售卖".$str."类的商品！</h3>";
    echo "<a href='javascript:window.history.back()'>返回</a>";
    echo "&nbsp&nbsp&nbsp";
    echo "<a href='showxiaoshou.php'>浏览销售记录</a>";

    echo "</center>";
    //           echo "<script>alert('该类产品还未创建词条');location='index.php';</script>";
}else{
    for($i=0;$i<$dateCount;$i++) {
        $result_arr = mysqli_fetch_assoc($result);

        $用户名[$i]=$result_arr['用户名'];
        $商品名[$i] = $result_arr['商品名'];
        $商标[$i] = $result_arr['商标'];
        $商品图片[$i] = $result_arr['商品图片'];
        $商品创建时间[$i]=$result_arr['商品创建时间'];
    }
}
?>

<div class="all-result">
    <?php
    $time=date("Y-m-d H:i:s",time());
    $time=strtotime($time);
    $k=0;
    for($i=0;$i<$dateCount;$i++) {
        $addtime = strtotime($商品创建时间[$i]);
        if ($type == 5 && ($time - $addtime) > 86400)
            continue;
        else {
            $k = 1;
            echo '<div class="res-box">';
            echo '<div class="res-img">';
            echo "<img src='{$商品图片[$i]}' height='100%' width='100%' />";
            echo '</div>';
            echo ' <div class="res-info"> ';
            echo '<ul class="res-xinxi">';
//                echo "<img src='{$商品图片[$i]}' height='100%' width='100%' />";
            echo '<li class="tar">商品：<a>' . "{$商品名[$i]}" . "</a></li>";
            echo '<li class="tar">商标：<a>' . "{$商标[$i]}" . "</a></li>";
            echo '</ul>';
            echo '</div>';
            echo "<center>";
            if (isset($_COOKIE["utype"]) && ($_COOKIE["utype"] == 2 || $_COOKIE["username"] == "{$用户名[$i]}")) {
                echo "<a href='action.php?action=delshangpin&商品名={$商品名[$i]}'>删除</a>";
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "<a href='editshangpin.php?商品名={$商品名[$i]}'>修改</a></td>";
            }
            echo "</center>";
            echo '</div>';
        }
    }
    if($k==0 && $type == 5){
        echo "<center>";
        echo "<h3>".$_GET['商店名']."暂时还没有新品出售！</h3>";
        echo "<a href='javascript:window.history.back()'>返回</a>";
        echo "&nbsp;&nbsp;&nbsp";
        echo "<a href='showshangpin.php?type=0'>浏览商品</a>";
        echo "</center>";
    }
    ?>
</div>
<script src="result/js/m.js"></script>
</body>

</html>