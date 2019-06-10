<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>乐淘优选网</title>
    <style type="text/css">

        form{
            width: 100%;
        }
        div {
            font-size: 22px;
            width: 680px;
            margin: 15px auto;
            text-align: left;
        }

        input {
            display: inline-block;
            font-size: 20px;
            border: 0;
            outline: none;
            background-color: inherit;
            box-sizing: border-box;
        }

        .title {
            float: left;
            width:20%;
            height: 100%;
            text-align: right;
        }

        .ipt {
            width: 50%;
            border: 1px solid black;
            text-align: center;
        }

        .image {
            width: 50%;
            height: 240px;
            border: 1px solid red;
            text-align: center;
        }

        .up {
            display: block;
            margin: auto;
            width: 40%;
            text-align: left;
            border: 1px solid #C4C4C4;
        }

        .up:active {
            background-color: #F0F0F0 !important;
        }

        .ok {
            display: inline-block;
            width: 40%;
            text-align: center;
        }

        .ok:active {
            background-color: #F0F0F0 !important;
        }
    </style>
</head>

<body>
<center>
<?php
    include_once "common.php";
    include_once  "menu.php";  //导入导航栏
    //1.导入配置文件
    require_once ("configue.php");

    //2.连接数据库，并选择数据库
    $link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or  die("数据库连接失败！");
    mysqli_select_db($link,DBNAME);

    //3.获取要修改的商品信息
    $sql="select  *  from  商品  where  商品名='{$_GET['商品名']}'";
    $result=mysqli_query($link,$sql);

    //4.判断是否获取到要编辑的商品信息
    if($result &&  mysqli_num_rows($result)>0){
        $shop=mysqli_fetch_assoc($result);  //解析出要修改的商品信息
    }else{
        die("没有找到要修改的商品信息！");
    }

?>
<h3>编辑商品信息</h3>
    <form action="action.php?action=updateshangpin" enctype="multipart/form-data" method="post" >
        <input type="hidden" name="oldpic"  value="<?php echo $shop['商品图片'];?>">
        <input type="hidden" name="旧商品名"  value="<?php echo $shop['商品名'];?>" />
        <div><input class="title" type="button"  value="商品名：" /><input class="ipt" type="text" name="商品名" value="<?php echo $shop['商品名'];?>"  placeholder="商品名" /></div>
        <div><input class="title" type="button"  value="商标：" /><input class="ipt" type="text"   name="商标" value="<?php  echo $shop['商标']; ?>"  placeholder="商标" /></div>
        <div><input class="title" type="button"  value="图片：" /><input class="image" class="ipt" type="image" src="<?php echo $shop['商品图片']; ?>" /></div>
        <div><input class="up" type="file"  name="pic"  /></div>
        <div><input class="ok" type="submit" value="修改" /><input class="ok" type="reset" value="重置" /></div>
    </form>
</center>
</body>

</html>

