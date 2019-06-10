<h2>乐淘优选网</h2>
<h3>
    <?php
        if(isset($_COOKIE['utype']) && $_COOKIE['utype']!=1) {
            echo '<a  href="login/merchantsignup.html">注册商家账号</a> |';
        }
    ?>
    <a  href="signout.php">注销</a> |
    <a  href="edityonghu.php">修改</a>
</h3>
<?php
if(isset($_COOKIE['utype']) && $_COOKIE['utype']!=1) {
    echo '<a  href="addcitiao.php">添加词条</a> |';
}
?>
<a  href="addshangpin.php">添加商品</a> |
<a  href="addshangjia.php">添加商家</a> |
<a  href="addxiaoshou.php">添加销售记录</a> |
<a  href="index.html">查询词条</a> |
<a  href="nointerest.html">不感兴趣</a>
<br />
<a  href="allresult.php?type=0">浏览词条</a> |
<a  href="showshangpin.php?type=0">浏览商品</a> |
<a  href="showshangjia.php">浏览商家</a> |
<a  href="showxiaoshou.php">浏览销售记录</a>
<hr width="80%"/>
