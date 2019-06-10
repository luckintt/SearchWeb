<html>
<head>
    <title>乐淘优选网 </title>
</head>
<body>
<center>
    <?php
        if(@$_COOKIE["islogin"]) {
            $username = $_COOKIE["username"];

            setcookie("username");
            setcookie("uid", time() - 3600);
            setcookie("utype", time() - 3600);
            setcookie("islogin", false);
            setcookie("count",time()-3600);

            echo "您已成功退出登录！<br>";
        }else{
            echo "您还没有登录！<br>";

        }
        header("Location:title.html");
    ?>
</center>

</body>
</html>
