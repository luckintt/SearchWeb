<html>
<head>
    <title>乐淘优选网</title>
</head>
<body>
<center>
    <?php
        include_once "common.php";
        if(!isset($_COOKIE["utype"]) ||  $_COOKIE["utype"]==0){
            include_once  "usermenu.php";
        }else{
            include_once  "menu.php"; //导入导航栏
        }
    ?>
    <h3>创建词条信息</h3>
    <form action="action.php?action=addcitiao" enctype="multipart/form-data" method="post" >

        <table border="0"  width="400">
            <tr>
                <td align="right">商店名：</td>
                <td><input type="text"  name="商店名" /></td>
            </tr>
            <tr>
                <td align="right">地址：</td>
                <td><input type="text"  name="地址" /></td>
            </tr>
            <tr>
                <td align="right">商品名：</td>
                <td><input type="text"  name="商品名" /></td>
            </tr>
            <tr>
                <td align="right">销售价格：</td>
                <td><input type="text"  name="销售价格" /></td>
            </tr>
            <tr>
                <td align="right">图片：</td>
                <td><input type="file"  name="pic" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit"  value="添加" />&nbsp;&nbsp;&nbsp;
                    <input type="reset"  value="重置" />
                </td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>