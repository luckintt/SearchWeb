<html>
<head>
    <title>乐淘优选网</title>
</head>
<body>
<center>
    <?php
    include_once "common.php";
    //1.导入配置文件
    require_once ("configue.php");

    //2.连接数据库，并选择数据库
    $link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or  die("数据库连接失败！");
    mysqli_select_db($link,DBNAME);
    
    //3.获取要修改的商家信息
    $sql="select  *  from  商家  where  商店名='{$_GET['商店名']}'  and  地址='{$_GET['地址']}'";
    $result=mysqli_query($link,$sql);
    
    //4.判断是否获取到要编辑的商家信息
    if($result &&  mysqli_num_rows($result)>0){
        $shop=mysqli_fetch_assoc($result);  //解析出要修改的商家信息
    }else{
        die("没有找到要修改的商家信息！");
    } 
    ?>
    
    <h3>编辑商家信息</h3>
    <form action="action.php?action=updateshangjia" enctype="multipart/form-data" method="post" >
        <input type="hidden" name="旧商店名"  value="<?php echo $shop['商店名'];?>" />
        <input type="hidden" name="旧地址"  value="<?php echo $shop['地址'];?>" />
        <table border="0"  width="310">
            <tr>
                <td align="right">商店名：</td>
                <td><input type="text"  name="商店名" value="<?php  echo $shop['商店名']; ?>"/></td>
            </tr>
            <tr>
                <td align="right">地址：</td>
                <td><input type="text"  name="地址" value="<?php  echo $shop['地址']; ?>"/></td>
            </tr>
            <tr>
                <td align="right">印象标签：</td>
                <td><input type="text"  name="印象标签" value="<?php  echo $shop['印象标签']; ?>"/></td>
            </tr>
            <tr>
                <td align="right" valign="top">口碑：</td>
                <td><input type="text"  name="口碑" value="<?php  echo $shop['口碑']; ?>"/></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit"  value="修改" />&nbsp;&nbsp;&nbsp;
                    <input type="reset"  value="重置" />
                </td>
            </tr>
        </table>
    </form>
    
</center>
</body>
</html>