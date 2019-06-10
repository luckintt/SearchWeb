<html>
<head>
    <title>乐淘优选网</title>
</head>
<body>
<center>
    <?php
        include_once "common.php";
    ?>
    <h3>创建商品信息</h3>
    <form action="action.php?action=addshangpin" enctype="multipart/form-data" method="post" >

        <table border="0"  width="400">
            <tr>
                <td align="right">商品名：</td>
                <td><input type="text"  name="商品名" /></td>
            </tr>
            <tr>
                <td align="right">商标：</td>
                <td><input type="text"  name="商标" /></td>
            </tr>
            <tr>
                <td align="right">类型：</td>
                <td>
                    <input type="radio" name="类型"  value="休闲零食" checked/>  休闲零食
                    <input type="radio" name="类型"  value="奶品水饮"/>  奶品水饮
                    <br>
                    <input type="radio" name="类型"  value="生鲜水果"/>  生鲜水果
                    <input type="radio" name="类型"  value="生活用品"/>  生活用品
                </td>
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