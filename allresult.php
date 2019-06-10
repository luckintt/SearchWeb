
<?php
require_once("functions.php");
date_default_timezone_set('prc');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title></title>
    <center>
        <?php
        if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
            include_once  "usermenu.php";
        }else{
            include_once  "menu.php"; //导入导航栏
        }

        ?>
        <h3>浏览词条信息</h3>
        <a  href="allresult.php?type=1">休闲零食</a> |
        <a  href="allresult.php?type=2">奶品水饮</a> |
        <a  href="allresult.php?type=3">生鲜水果</a> |
        <a  href="allresult.php?type=4">生活用品</a> |
        <a  href="allresult.php?type=5">新品推荐</a>
        <br>
        <a  href="noresult.php?type=1">不看休闲零食</a> |
        <a  href="noresult.php?type=2">不看奶品水饮</a> |
        <a  href="noresult.php?type=3">不看生鲜水果</a> |
        <a  href="noresult.php?type=4">不看生活用品</a> |
        <a  href="noresult.php?type=5">不看新品推荐</a>
    </center>

    <script src="jquery-2.1.3.min.js"></script>
    <script type="text/javascript">
        function check() {
            var keywords = document.getElementById("search2").value;
            if(keywords != ""){
                $("#btn_search").prop("type","submit");
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

<!--
    描述：返回数据的区域    开始
-->


<?php

//连接数据库
$conn=connectdb();
if(!$conn){
    die('Can  not  connect  db');
}

/*$result=mysqli_query($conn,"select  词条.商品图片,词条.商店名,词条.地址,词条.商品名,词条.销售价格,商家.印象标签,商家.口碑,词条.词条创建时间  from  词条,商家
                                     where  词条.商店名=商家.商店名  and  词条.地址=商家.地址;");*/
$type=$_GET['type'];
$str="";
$sql="";

if($type>=1 && $type<5){
//    if($type==5)
//
//        $sql="select * from 词条,商家 where ((strtotime(词条.词条创建时间)-'{$time}')/86400)<1 and 词条.商店名=商家.商店名  and  词条.地址=商家.地址 order by 商家.口碑  DESC;";
//    else{
        if($type==1)
            $str="休闲零食";
        else if($type==2)
            $str="奶品水饮";
        else if($type==3)
            $str="生鲜水果";
        else
            $str="生活用品";
        $sql="select  词条.用户名,词条.商品图片,词条.商店名,词条.地址,词条.商品名,词条.销售价格,商家.印象标签,商家.口碑,词条.词条创建时间  from  词条,商家,商品
                                     where  词条.商店名=商家.商店名  and  词条.地址=商家.地址  and 词条.商品名=商品.商品名 and 商品.类型='{$str}' order by 商家.口碑  DESC;";
 //   }
}else if($type==5)
    $sql="select  词条.用户名,词条.商品图片,词条.商店名,词条.地址,词条.商品名,词条.销售价格,商家.印象标签,商家.口碑,词条.词条创建时间  from  词条,商家
                                     where  词条.商店名=商家.商店名  and  词条.地址=商家.地址 order by 词条.词条创建时间  DESC;";
    else{
        $sql="select  词条.用户名,词条.商品图片,词条.商店名,词条.地址,词条.商品名,词条.销售价格,商家.印象标签,商家.口碑,词条.词条创建时间  from  词条,商家
                                     where  词条.商店名=商家.商店名  and  词条.地址=商家.地址  order by 商家.口碑  DESC;";
    }
$result=mysqli_query($conn,$sql);
$dateCount=mysqli_num_rows($result);
if($dateCount<=0){
    echo "<center>";
    echo "<h3>该类产品还未创建词条！</h3>";
    echo "<a href='javascript:window.history.back()'>返回</a>";
    echo "&nbsp&nbsp&nbsp";
    if(isset($_COOKIE['utype']) && $_COOKIE['utype']!=1)
        echo "<a href='addcitiao.php'>创建词条</a>";
    else
        echo "<a href='allresult.php'>浏览词条</a>";
    echo "</center>";
        //           echo "<script>alert('该类产品还未创建词条');location='index.php';</script>";
}else{
    for($i=0;$i<$dateCount;$i++){
        $result_arr=mysqli_fetch_assoc($result);

        $用户名[$i]=$result_arr['用户名'];
        $商品图片[$i]=$result_arr['商品图片'];
        $商店名[$i]=$result_arr['商店名'];
        $地址[$i]=$result_arr['地址'];
        $商品名[$i]=$result_arr['商品名'];
        $销售价格[$i]=floatval($result_arr['销售价格']);
        $印象标签[$i]= $result_arr['印象标签'];
        $口碑[$i]=intval($result_arr['口碑']);
        $词条创建时间[$i]=$result_arr['词条创建时间'];

//                   echo "<br>{$印象标签[$i]}<br>";
    }
}
?>

<div class="all-result">
    <?php
    $time=date("Y-m-d H:i:s",time());
    $time=strtotime($time);
    $k=0;
    for($i=0;$i<$dateCount;$i++) {
        $addtime = strtotime($词条创建时间[$i]);
        if ($type == 5 && ($time - $addtime) > 86400)
            continue;
        else {
            $k=1;
            echo '<div class="res-box">';
            echo '<div class="res-img">';
            echo "<img src='{$商品图片[$i]}' height='100%' width='100%' />";
            echo '</div>';
            echo ' <div class="res-info"> ';
            echo '<ul class="res-xinxi">';
//                echo "<img src='{$商品图片[$i]}' height='100%' width='100%' />";
            echo '<li class="tar">商品：<a>' . "{$商品名[$i]}" . "</a></li>";
            echo '<li class="tar">商店：<a>' . "{$商店名[$i]}" . "</a></li>";
            echo '<li class="tar">地址：<a>' . "{$地址[$i]}" . "</a></li>";
            echo '<li class="tar">价格：<a>' . "{$销售价格[$i]}" . "元</a></li>";
            echo '<li class="tar">印象：<a class="effect">';
            $count=explode('#',$印象标签[$i]);
            if($count){
                echo "<select style='width:120px'>";
                foreach ($count as $value){
                    echo "<option selected='selected'>$value</option>";
                }
                echo "</select>";
            }
            echo "</a></li>";
            echo '<li class="tar">口碑：<a>' . "{$口碑[$i]}" . "</a></li>";
//    echo '<li class="tar">创建时间：<i>' . "{$词条创建时间[$i]}" . "</i></li>";
            echo '</ul>';
            echo '</div>';
//        echo '<a href="editcitiao.php"><input type="button" id="edit" value="修改" /></a>';
            echo "<center>";
            if ((isset($_COOKIE["utype"]) &&  $_COOKIE["utype"] == 2) || $_COOKIE["username"] == "{$用户名[$i]}") {
                echo "<a href='action.php?action=delcitiao&商店名={$商店名[$i]}&地址={$地址[$i]}&商品名={$商品名[$i]}'>删除</a>";
                echo "&nbsp&nbsp&nbsp";
                echo "<a href='editcitiao.php?商店名={$商店名[$i]}&地址={$地址[$i]}&商品名={$商品名[$i]}'>修改</a></td>";
            }else{
                echo "<a href='action.php?action=delcitiao&商店名={$商店名[$i]}&地址={$地址[$i]}&商品名={$商品名[$i]}'onclick='return false'><font color='gray'>删除</font></a>";
                echo "&nbsp&nbsp&nbsp";
                echo "<a href='editcitiao.php?商店名={$商店名[$i]}&地址={$地址[$i]}&商品名={$商品名[$i]}'onclick='return false'><font color='gray'>修改</font></a></td>";
            }
            echo "</center>";
            echo '</div>';
        }
    }
    if($k==0 && $type == 5){
        echo "<center>";
        echo "<h3>暂时还没有新词条被创建！</h3>";
        echo "<a href='javascript:window.history.back()'>返回</a>";
        echo "&nbsp;&nbsp;&nbsp";
        echo "<a href='allresult.php?type=0'>浏览词条</a>";
        echo "</center>";
    }
    ?>
</div>
<script src="result/js/m.js"></script>
</body>

</html>