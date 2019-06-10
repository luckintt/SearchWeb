html>

<head>
    <title>销售信息管理</title>
</head>
<body>
<center>
    <?php
    if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
        include_once  "usermenu.php";
    }else{
        include_once  "menu.php"; //导入导航栏
    }
    //1.导入配置文件
    require("config.php");
    //2.连接数据库，并且选择数据库
    $link = mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");
    mysqli_select_db($link,DBNAME);
    //3.获取要修改的商品信息的查询
    $sql = "select * from sale where thingsId={$_GET['thingsId']} and shopId={$_GET['shopId']}";
    $result = mysqli_query($link,$sql);
    if($result && mysqli_num_rows($result)>0){
        $sale = mysqli_fetch_assoc($result);
        $sql1="select * from addidas where shopId='{$_GET['shopId']}'";
        $result1 = mysqli_query($link,$sql1);
        $shop = mysqli_fetch_assoc($result1);
        $sql2="select * from things where thingsId={$_GET['thingsId']}";
        $result2 = mysqli_query($link,$sql2);
        $things = mysqli_fetch_assoc($result2);
    }else{
        die("没有找到要修改的销售信息！");
    }

    ?>
    <h3>编辑销售信息</h3>
    <form action="action.php?action=editsale" enctype="multipart/form-data" method="post">
        <input type="hidden" name="oldshopId" value="<?php echo $shop['shopId'];?>"/>
        <input type="hidden" name="oldthingsId" value="<?php echo $things['thingsId'];?>"/>

        <table border="1" width="350">
            <tr>
                <td align="right">商店名称：</td>
                <td><input type="text" name="shopName" value="<?php echo $shop['shopName'];  ?>"/></td>
            </tr>
            <tr>
                <td align="right">地址：</td>
                <td><input type="text" name="shopAddress" value="<?php echo $shop['shopAddress'];  ?>"/></td>
            </tr>
            <tr>
                <td align="right">商品名称：</td>
                <td><input type="text" name="thingsName" value="<?php echo $things['thingsName'];  ?>"/></td>
            </tr>

            <tr>
                <td align="right" valign="top">口碑</td>
                <td><textarea rows = "5" cols = "25" name = "note" ><?php echo $sale['note'];?></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="修改"/>&nbsp;&nbsp;&nbsp;
                    <input type="reset" value="重置"/>
                </td>
            </tr>

        </table>
    </form>
</center>
</body>
</html>