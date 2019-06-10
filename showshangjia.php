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
    <h3>浏览商家信息</h3>

    <table border="1"  width="700">
        <tr>
            <th>商店名</th>
            <th>地址</th>
            <th>印象标签</th>
            <th>口碑</th>
            <th>操作</th>
        </tr>
        <?php
        //从数据库中读取信息并输出到浏览器表格中
        //1.导入配置文件
        require ("configue.php");

        //2.连接数据库，并选择数据库
        $link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or die("数据库连接失败！");
        mysqli_select_db($link,DBNAME);

        //3.执行商家信息查询
        $sql="select  *  from  商家 order by 口碑  DESC ";
        $result=mysqli_query($link,$sql);

        //4.解析商品信息（解析结果集）
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td align='center'>{$row['商店名']}</td>";
            echo "<td align='center'>{$row['地址']}</td>";
            echo "<td align='center' width='200'>";
                $count=explode('#',$row['印象标签']);
                if($count){
                    echo "<select style='width:200px'>";
                    $m=1;
                    foreach ($count as $value){
                            echo "<option selected='selected'>$value</option>";
                    }
                    echo "</select>";
                }
            echo  "</td>";
            echo "<td align='center'>{$row['口碑']}</td>";
            if (isset($_COOKIE["utype"]) &&  ($_COOKIE["utype"] == 2 || $_COOKIE["username"] == "{$row['用户名']}")) {
                echo "<td align='center'>
                   <a  href='action.php?action=delshangjia&商店名={$row['商店名']}&地址={$row['地址']}'> 删除</a>";

            }else{
                echo "<td align='center'>
                   <a  href='action.php?action=delshangjia&商店名={$row['商店名']}&地址={$row['地址']}'onclick='return false'><font color='gray'>删除</font></a>";
            }
            echo "  <a  href='goinshangjia.php?用户名={$row['用户名']}&商店名={$row['商店名']}&地址={$row['地址']}&type=0'>进入商店</a></td>";
            echo "</tr>";
        }
        //5.释放结果集，关闭数据库
        mysqli_close($link);
        ?>
    </table>
</center>
</body>
</html>