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
    //1.导入配置文件
    require_once ("configue.php");

    //2.连接数据库，并选择数据库
    $link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or  die("数据库连接失败！");
    mysqli_select_db($link,DBNAME);

    //3.获取要修改的用户信息
    $sql="select  *  from  用户  where 用户编号='{$_COOKIE['uid']}'";
    $result=mysqli_query($link,$sql);

    //4.判断是否获取到要编辑的用户信息
    if($result &&  mysqli_num_rows($result)>0){
        $user=mysqli_fetch_assoc($result);  //解析出要修改的用户信息
    }else{
        die("没有找到要修改的用户信息！");
    }

    ?>
    <h3>编辑用户信息</h3>
    <form action="action.php?action=updateyonghu" enctype="multipart/form-data" method="post" >
        <input type="hidden" name="oldpic"  value="<?php echo $user['用户头像'];?>">
        <input type="hidden" name="id"  value="<?php echo $_COOKIE['uid'];?>" />
        <div><input class="title" type="button"  value="用户名：" /><input class="ipt" type="text" name="用户名" value="<?php echo $user['用户名'];?>"  placeholder="用户名" /></div>
        <div><input class="title" type="button"  value="旧密码：" /><input class="ipt" type="password"   name="旧密码" value=""  placeholder="请输入原始密码" /></div>
        <div><input class="title" type="button"  value="新密码：" /><input class="ipt" type="password"   name="新密码" value=""  placeholder="请设置新密码" /></div>
        <div><input class="title" type="button"  value="创建词条个数：" /><input class="ipt" type="button" value="<?php echo $user['创建词条个数']; ?>" /></div>
        <div><input class="title" type="button"  value="头像：" /><input class="image" class="ipt" type="image" src="<?php echo $user['用户头像']; ?>" /></div>
        <div><input class="up" type="file"  name="pic"  /></div>
        <div><input class="ok" type="submit" value="修改" /><input class="ok" type="reset" value="重置" /></div>
    </form>
</center>
</body>

</html>

