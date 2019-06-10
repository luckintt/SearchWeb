<html>
<head>
    <title>乐淘优选网</title>
</head>
<body>
<center>
    <?php
    if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
        include_once  "usermenu.php";
    }else{
        include_once  "menu.php"; //导入导航栏
    }
    ?>
    <h3>浏览销售记录</h3>

    <table border="1"  width="700">
        <tr>
            <th>商店名</th>
            <th>地址</th>
            <th>商品名</th>
            <th>销售价格</th>
            <th>操作</th>
        </tr>
        <?php
        //从数据库中读取信息并输出到浏览器表格中
        //1.导入配置文件
        require_once  "configue.php";

        //2.连接数据库，并选择数据库
        $link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or die("数据库连接失败！");
        mysqli_select_db($link,DBNAME);

        //3.执行商家信息查询
        $sql="select  *  from  销售,商家 where 销售.商店名=商家.商店名 and 销售.地址=商家.地址 order by 商家.口碑  DESC";
        $result=mysqli_query($link,$sql);

        //4.解析商品信息（解析结果集）
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>{$row['商店名']}</td>";
            echo "<td>{$row['地址']}</td>";
            echo "<td>{$row['商品名']}</td>";
            echo "<td>{$row['销售价格']}元</td>";
            if (isset($_COOKIE["utype"]) &&  ($_COOKIE["utype"] == 2 || $_COOKIE["username"] == "{$row['用户名']}")) {
                echo "<td>
                    <a  href='action.php?action=delxiaoshou&商店名={$row['商店名']}&地址={$row['地址']}&商品名={$row['商品名']}'>删除</a>
                    <a href='editxiaoshou.php?商店名={$row['商店名']}&地址={$row['地址']}&商品名={$row['商品名']}'>修改</a></td>";
            }else{
                echo "<td>
                    <a  href='action.php?action=delxiaoshou&商店名={$row['商店名']}&地址={$row['地址']}&商品名={$row['商品名']}'  onclick='return false'><font color='gray'>删除</font></a>
                    <a href='editxiaoshou.php?商店名={$row['商店名']}&地址={$row['地址']}&商品名={$row['商品名']}' onclick='return false'><font color='gray'>修改</font></a></td>";
            }
            echo "</tr>";
        }
        //5.释放结果集，关闭数据库

        ?>
    </table>
</center>
</body>
</html>
<!--                 <a href='action.php?action=delshangjia&商店名={$row['商店名']}&地址={$row['地址']}'>删除 </a>  -->