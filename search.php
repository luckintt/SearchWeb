<html>
<head>
    <title>商品管理系统</title>
    <script type="text/javascript">
        function dodel(shopId,thingsId){
            if(confirm("确定要删除嘛?")){
                window.location="action.php?action=delsale&shopId="+shopId+"&thingsId="+thingsId;
            }
        }
    </script>
</head>
<body>
<center>
    <?php
//    if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==1)
//        include_once  "menu.php"; //导入导航栏
//    else
        include_once  "common.php";
    //1.导入配置文件
    require("dbconfig.php");
    //2.获取数据Mysql连接，选择数据库
    $link = mysqli_connect(HOST,USER,PASS) or die("数据库连接失败！");
    mysqli_select_db($link,DBNAME);
    ?>

    <h3>分页浏览销售记录</h3>
    <!------------------------ 搜索表单------------->
    <form action="search.php" method="get">
        商店名称: <input type="text" name="shopName" size="8" value="<?php if(empty($_GET['shopName'])){echo '';}else{echo $_GET['shopName'];}?>">&nbsp;
        商品名称: <input type="text" name="thingsName" size="8" value="<?php if(empty($_GET['thingsName'])){echo '';}else{echo $_GET['thingsName'];};?>">&nbsp;
        价格: <input type="text" name="thingsPrice" size="8" value="<?php if(empty($_GET['thingsPrice'])){echo '';}else{echo $_GET['thingsPrice'];}?>">&nbsp;
        类型: <select name="thingsType">
                  <?php
                    include("dbconfig.php");
                    foreach ($typelist as $k=>$v){
                        $sd = ($_GET['thingsType']==$k)?"selected":"";//是否是当前的类型
                        echo"<option value='{$k}'{$sd}>{$v}</option>";
                    }
                  ?>
              </select>
        适用人群:<select name="thingsSex">
                      <?php
                        include("dbconfig.php");
                        foreach ($sexlist as $k=>$v){
                            $sd = ($_GET['thingsSex']==$k)?"selected":"";//是否是当前的类型
                            echo"<option value='{$k}'{$sd}>{$v}</option>";
                        }
                      ?>
                </select>
        
        <input type="submit" value="搜索"/>
        <input type="button" value="全部信息" onclick="window.location='search.php'"/>
        <!——————————————————————————————>

        <table width = "880" border = "1">
            <tr>
                <th>商店名称</th><th>地址</th><th>商品名称</th>
                <th>商品图片</th><th>价格</th><th>库存量</th>
                <th>尺寸</th><th>类型</th><th>适用人群</th>
                <th>操作</th>
            </tr>
            <?php
            //******************************************
            //封装搜索信息
            $shopwherelist = array();//定义一个封装搜索条件数组变量
            $thingswherelist = array();//定义一个封装搜索条件数组变量
            $urllist=array();//定义了一个封装搜索条件的url数组,用于放置到url后面做其参数使用

            //判断商店名称是否有值，若有则封装次搜索条件
            if(!empty($_GET["shopName"])){
                $shopwherelist[] = "shopName like '%{$_GET['shopName']}%'";
                $urllist[]="shopName={$_GET['shopName']}";
            }
            //判断商品名称是否有值，若有则封装次搜索条件
            if(!empty($_GET["thingsName"])){
                $thingswherelist[] = "thingsName like '%{$_GET['thingsName']}%'";
                $urllist[]="thingsName={$_GET['thingsName']}";
            }
            //判断价格是否有值，若有则封装次搜索条件
            if(!empty($_GET["thingsPrice"])){
                $thingswherelist[] = "thingsPrice like '%{$_GET['thingsPrice']}%'";
                $urllist[]="thingsPrice={$_GET['thingsPrice']}";
            }
            //判断类型是否有值，若有则封装次搜索条件
            if(!empty($_GET["thingsType"])){
                $thingswherelist[] = "thingsType like '%{$typelist[$_GET['thingsType']]}%'";
                $urllist[]="thingsType={$typelist[$_GET['thingsType']]}";
            }
            //判断适用人群是否有值，若有则封装次搜索条件
            if(!empty($_GET["thingsSex"])){
                $thingswherelist[] = "thingsSex like '%{$sexlist[$_GET['thingsSex']]}%'";
                $urllist[]="thingsSex={$sexlist[$_GET['thingsSex']]}";
            }

            //2.1 .插入分页处理代码
            //1.定义一些分页变量
            $page=isset($_GET["page"])?$_GET["page"]:1;         //当前页号
            $pageSize=3;     //页大小
            $maxRows;      //最大数据条
            $maxPages;     //最大页数

            //2.获取最大数据条数
            if(count($shopwherelist)>0 &&  count($thingswherelist)<=0){
                $shopwhere = implode(" and ",$shopwherelist);       //将数组合并成字符串
                $sql = "select count(*) from addidas where  {$shopwhere}";
            }
            if(count($shopwherelist)<=0 &&  count($thingswherelist)>0){
                $thingswhere =implode(" and ",$thingswherelist);       //将数组合并成字符串
                $sql = "select count(*) from things where  {$thingswhere}";
            }
            if(count($shopwherelist)>0 &&  count($thingswherelist)>0){
                $shopwhere = implode(" and ",$shopwherelist);       //将数组合并成字符串
                $thingswhere = implode(" and ",$thingswherelist);       //将数组合并成字符串
                $sql = "select count(*) from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId  and  {$thingswhere} and  {$shopwhere}";
            }
            if(count($shopwherelist)<=0 &&  count($thingswherelist)<=0){
                $sql = "select count(*) from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId";
            }
            echo "<br>".$sql;

            $res = mysqli_query($link,$sql);
            $result_arr=mysqli_fetch_array($res);
            $maxRows =  $result_arr[0];//定义从结果集中获取总数据条数这个值

            //3.计算出共计最大页数
            $maxPages = ceil($maxRows/$pageSize);//采用进1求整法获取最大页数
            //4.判断页数是否越界（效验当前页数）
            if($page>$maxPages){
                $page= $maxPages;
            }
            if($page<1){
                $page=1;
            }
            //5.拼装分页sql语句片段
            $limit = " limit ".(($page-1)*$pageSize).",{$pageSize}";   //起始位置是当前页数减1乘页大小
            //3.执行查询
            if(count($shopwherelist)>0 &&  count($thingswherelist)<=0){
                $shopwhere = implode(" and ",$shopwherelist);       //将数组合并成字符串
                $sql1 = "select * from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId and {$shopwhere} order by addtime desc {$limit}";
            }
            if(count($shopwherelist)<=0 &&  count($thingswherelist)>0){
                $thingswhere =implode(" and ",$thingswherelist);       //将数组合并成字符串
                $sql1 = "select * from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId and {$thingswhere} order by addtime desc {$limit}";
            }
            if(count($shopwherelist)>0 &&  count($thingswherelist)>0){
                $shopwhere = implode(" and ",$shopwherelist);       //将数组合并成字符串
                $thingswhere = implode(" and ",$thingswherelist);       //将数组合并成字符串
                $sql1 = "select * from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId and {$thingswhere} and  {$shopwhere} order by addtime desc {$limit}";
            }
            if(count($shopwherelist)<=0 &&  count($thingswherelist)<=0){
                $sql1 = "select * from addidas,things,sale where addidas.shopId=sale.shopId  and  things.thingsId=sale.thingsId order by addtime desc {$limit}";
            }
            echo "<br>".$sql1;

            $result1 = mysqli_query($link,$sql1);

            //4.解析结果
            while($row = mysqli_fetch_assoc($result1))
            {
                print_r($row);
                echo "<tr>";
                echo "<td>{$row['shopName']}</td>";
                echo "<td>{$row['shopAddress']}</td>";
                echo "<td>{$row['thingsName']}</td>";
                echo "<td align='center'><img src='./uploads/s_{$row['thingsPic']}'/></td>";
                echo "<td>{$row['thingsPrice']}</td>";
                echo "<td>{$row['thingsTotal']}</td>";
                echo "<td>{$row['thingsSize']}</td>";
                echo "<td>{$typelist[$row['thingsType']]}</td>";
                echo "<td>{$sexlist[$row['thingsSex']]}</td>";
                echo "<td><a href='javascript:dodel({$row['shopId']},{$row['thingsId']})'>删除</a>
                           <a href='editsale.php?thingsId={$row['thingsId']}&shopId={$row['shopId']}'>修改</a> </td>";
                echo "</tr>";
            }
            //5.释放资源，关闭连接
            mysqli_free_result($result1);
            mysqli_close($link);
            ?>


        </table>
        <?php
        $url = "&".implode("&",$urllist);
        //输出分页信息，显示上一页和下一页的连接
        echo "<br>";
        echo "当前{$page}/{$maxPages}页 共计{$maxRows}条";
        echo "<a href='search.php?page=1 {$url}'>首页</a>";
        echo "<a href='search.php?page=".($page-1)."{$url}'>上一页</a>";
        echo "<a href='search.php?page=".($page+1)."{$url}'>下一页</a>";
        echo "<a href='search.php?page={$maxPages}{$url}'>末页</a>";
        ?>
    </form>
</center>
</body>
</html>