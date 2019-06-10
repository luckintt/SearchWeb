<?php
//执行商品信息的增、删、改的操作
date_default_timezone_set('prc');
//一、导入配置文件和函数库文件
require_once ('configue.php');
require_once ('functions.php');
require_once ("common.php");

//二、连接MySQL，选择数据库
$link=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW) or die("数据库连接失败！");
mysqli_select_db($link,DBNAME);

//三、获取action参数的值，并作对应的操作
//print_r($_GET['action']);
switch($_GET['action']){
    case 'addcitiao'://添加
        //1.获取添加信息

        $用户名=$_COOKIE['username'];
        $商店名=$_POST['商店名'];
        $地址=$_POST['地址'];
        $商品名=$_POST['商品名'];
        $销售价格=$_POST['销售价格'];
        $词条创建时间=time();
        $词条创建时间=date("Y-m-d H:i:s",$词条创建时间);

        //2.验证
        $result=mysqli_query($link,"select  *  from  销售  where  商店名='{$商店名}' and  地址='{$地址}' and  商品名='{$商品名}';");
        $dateCount=mysqli_num_rows($result);
        if($dateCount<=0){
            $result1=mysqli_query($link,"select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}';");
            $dateCount1=mysqli_num_rows($result1);
            $result2=mysqli_query($link,"select  *  from  商品  where  商品名='{$商品名}';");
            $dateCount2=mysqli_num_rows($result2);

            if($dateCount1>0 && $dateCount2>0){
                echo "<center>";
                echo "<h3>该商家没有销售此商品的记录！</h3>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showxiaoshou.php'>浏览销售信息</a>";
                echo "<br>";
                echo "</center>";
            }else{
                if($dateCount1<=0){
                    echo "<center>";
                    echo "<h3>商店名或地址输入错误！</h3>";
                    echo "<a href='javascript:window.history.back()'>返回</a>";
                    echo "&nbsp;&nbsp;&nbsp";
                    echo "<a href='showshangjia.php'>浏览商家信息</a>";
                    echo "<br>";
                    echo "</center>";
                }

                if($dateCount2<=0){
                    echo "<center>";
                    echo "<h3>商品名不存在</h3>";
                    echo "<a href='javascript:window.history.back()'>返回</a>";
                    echo "&nbsp;&nbsp;&nbsp";
                    echo "<a href='showshangpin.php?type=0'>浏览商品信息</a>";
                    echo "<br>";
                    echo "</center>";
                }
            }
        }else{
            $resultt=mysqli_query($link,"select  *  from  词条  where  商店名='{$商店名}' and  地址='{$地址}' and  商品名='{$商品名}';");
            $dateCountt=mysqli_num_rows($resultt);
            echo "</center>";
            if($dateCountt>0){
                echo "<center>";
                echo "该词条已经存在!<br>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='allresult.php?type=0'>查看词条信息</a>";
                echo "</center>";
            }else{
                //3.执行图片上传
                //没有图片上传则使用默认图片
                $upfile=$_FILES["pic"];
                if($upfile["error"]==4){
                    echo "<center>";
                    echo "没有文件上传，将使用默认图片。<br>";
                    $result=mysqli_query($link,"select  *  from  商品   where  商品名='{$商品名}';");
                    $result_arr=mysqli_fetch_assoc($result);
                    $pic=$result_arr['商品图片'];
                    echo "</center>";
                }else{
                    $upinfo=uploadFile("pic","./uploads/");
                    if($upinfo["error"]===false){
                        echo "<center>";
                        die("图片信息上传失败：".$upinfo["info"]);
                        echo "</center>";
                    }else{
                        //上传成功
                        $pic="./uploads/".$upinfo["info"]; //获取上传成功的图片名
                    }
                }

                //4.执行图片缩放
//        imageUpdateSize("./uploads/".$pic,50,50);
                //5.拼装sql语句，并执行添加
                $sql="insert  into  词条  (用户名,商店名,地址,商品名,商品图片,销售价格,词条创建时间)  values('{$用户名}','{$商店名}','{$地址}','{$商品名}','$pic','{$销售价格}','{$词条创建时间}')";
//            echo $sql."<br>";
                mysqli_query($link,$sql);

                //6.判断并输出结果
                if(mysqli_affected_rows($link)>0){
                    $sql1="update  用户  set  创建词条个数=创建词条个数+1  where  用户名='{$用户名}'";
//                echo $sql1."<br>";
                    mysqli_query($link,$sql1);
                    echo "<center>";
                    if(mysqli_affected_rows($link)>0){
                        echo "用户创建词条个数更新成功<br>";
                    }else{
                        echo "用户创建词条个数更新失败<br>";
                    }
                    echo "词条创建成功！<br>";
                    echo "</center>";
                }else{
                    echo "<center>";
                    echo "词条创建失败！<br>".mysqli_error($link);
                    echo "</center>";
                }
                echo "<center>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='allresult.php?type=0'>查看词条信息</a>";
                echo "</center>";
            }
        }
        break;

    case 'addshangjia':
        echo "<center>";
        //1.获取添加信息
        if(isset($_COOKIE["utype"]) && $_COOKIE["utype"]!=0){
            //1.获取添加信息
            $商店名=$_POST['商店名'];
            $地址=$_POST['地址'];
            //2.验证
            $sql="select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}'";
            $result=mysqli_query($link,$sql);
            $dateCount=mysqli_num_rows($result);
            $印象标签 ="#".$_COOKIE['username'].":无";
//        echo $sql."<br>".$dateCount;
            if($dateCount>0) {//该商家已经存在
                echo "该商家已经存在!<br>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
            }else{
                $sql1="insert  into  商家 values  ('{$_COOKIE['username']}','{$商店名}','{$地址}','{$印象标签}',80)";
                mysqli_query($link,$sql1);
                if(mysqli_affected_rows($link)>0){
                    echo "创建商家信息成功！<br>";
                }else{
                    echo "创建商家信息失败！<br>".mysqli_error($link);
                }
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showshangjia.php'>浏览商家信息</a>";
            }
        }else{
            if($_COOKIE["count"]<3) {
                //1.获取添加信息
                $商店名 = $_POST['商店名'];
                $地址 = $_POST['地址'];
                $印象标签 ="#".$_COOKIE['username'].":". $_POST['印象标签'];
                $口碑 = $_POST['口碑'];
                //2.验证
                $sql = "select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}'";
                $result = mysqli_query($link, $sql);
                $dateCount = mysqli_num_rows($result);
//        echo $sql."<br>".$dateCount;
                if ($dateCount > 0) {//该商家已经存在
                    echo "该商家印象已经存在!<br>";
                    $result_arr = mysqli_fetch_assoc($result);
                    $口碑 = ($口碑 + $result_arr['口碑']) / 2;
                    $印象标签=$印象标签.$result_arr['印象标签'];
                    $sql = "update  商家 set 商店名='{$商店名}',地址='{$地址}',印象标签='{$印象标签}',口碑='{$口碑}'  where  商店名='{$商店名}' and  地址='{$地址}'";
                    mysqli_query($link, $sql);

                    //6.判断是否修改成功
                    if (mysqli_affected_rows($link) > 0) {
                        $count=$_COOKIE["count"]+1;
                        setcookie("count",$count,time()+60*60*24*7);
                        echo "更新商家评价成功<br>";
                    } else {
                        echo "更新商家评价失败<br>" . mysqli_error($link);
                    }
                }
                else{
                    echo "商店名或地址输入错误！<br>";
                }
            }else{
                echo "您添加商家印象太过频繁，请稍后再添加！<br>";
            }
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showshangjia.php'>浏览商家信息</a>";
        }
        echo "</center>";
        break;

    case 'addshangpin':
        echo "<center>";
        //1.获取添加信息
        $商品名=$_POST['商品名'];
        $商标=$_POST['商标'];
        $类型=$_POST['类型'];
        $商品创建时间=time();
        $商品创建时间=date("Y-m-d H:i:s",$商品创建时间);
        //2.验证
        if(empty($商品名)){
            echo "<h3>商品名不能为空！</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
        }else{
            $sql="select  *  from  商品  where  商品名='{$商品名}'";
            $result=mysqli_query($link,$sql);
            $dateCount=mysqli_num_rows($result);
            if($dateCount>0){
                echo "<h3>该商品已经存在！</h3>";
            }else{
                //3.执行图片上传
                //没有图片上传则使用默认图片
                $upfile=$_FILES["pic"];
                if($upfile["error"]==4){
                    echo "没有文件上传，将使用默认图片。<br>";
                    $pic='./img/default.jpg';
                }else{
                    $upinfo=uploadFile("pic","./uploads/");
                    if($upinfo["error"]===false){
                        die("图片信息上传失败：".$upinfo["info"]);
                    }else{
                        //上传成功
                        $pic="./uploads/".$upinfo["info"]; //获取上传成功的图片名
                    }
                }

                //4.执行图片缩放
//        imageUpdateSize("./uploads/".$pic,50,50);

                //5.拼装sql语句，并执行添加
                $sql="insert  into  商品  (用户名,商品名,商标,商品图片,类型,商品创建时间)  values  ('{$_COOKIE['username']}','{$商品名}','{$商标}','$pic','{$类型}','{$商品创建时间}')";
//                echo $sql."<br>";
                mysqli_query($link,$sql);

                //6.判断并输出结果
                if(mysqli_affected_rows($link)>0){
                    echo "商品添加成功！<br>";
                }else{
                    echo "商品添加失败！<br>".mysqli_error($link);
                }
            }

            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo " <a href='showshangpin.php?type=0'>浏览商品信息</a>";
        }
        echo "</center>";
        break;

    case 'addxiaoshou':
        echo "<center>";
        //1.获取添加信息
        $商店名=$_POST['商店名'];
        $地址=$_POST['地址'];
        $商品名=$_POST['商品名'];
        $销售价格=$_POST['销售价格'];

        //2.验证
        $result=mysqli_query($link,"select  *  from  销售  where  商店名='{$商店名}' and  地址='{$地址}' and  商品名='{$商品名}';");
        $dateCount=mysqli_num_rows($result);
        if($dateCount<=0) {   //该销售记录不存在
            $sql1 = "select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}'";
            $result1 = mysqli_query($link, $sql1);
            $dateCount1 = mysqli_num_rows($result1);
            $sql2 = "select  *  from  商品  where  商品名='{$商品名}'";
            $result2 = mysqli_query($link, $sql2);
            $dateCount2 = mysqli_num_rows($result2);
//            echo $sql1 . "<br>" . $dateCount1 . "<br>" . $sql2 . "<br>" . $dateCount2 . "<br>";
            if ($dateCount1 <= 0) {
                echo "<h3>商店名或地址输入错误！</h3>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='addshangjia.php'>添加商家信息</a>";
                echo "<br>";
            }
            if ($dateCount2 <= 0) {
                echo "<h3>商品名不存在</h3>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='addshangpin.php'>添加商品信息</a>";
                echo "<br>";
            }

            //3.拼装sql语句并执行添加
            if ($dateCount1 > 0 && $dateCount2 > 0) {
                $sql = "insert  into  销售  values  ('{$_COOKIE['username']}','{$商店名}','{$地址}','{$商品名}','{$销售价格}');";
//                echo $sql . "<br>";
                mysqli_query($link, $sql);

                //4.判断并输出结果
                if (mysqli_affected_rows($link) > 0) {
                    echo "销售记录添加成功！<br>";
                } else {
                    echo "销售记录添加失败！<br>" . mysqli_error($link);
                }
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showxiaoshou.php'>查看销售记录</a>";
            }
        }else{
            echo "该销售记录已经存在！<br>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showxiaoshou.php'>查看销售记录</a>";
        }
        echo "</center>";
        break;
    
    case 'delcitiao'://删除
        echo "<center>";
        //修改词条信息
        $result=mysqli_query($link,"select  *  from  词条  where  商店名='{$_GET['商店名']}'  and  地址='{$_GET['地址']}'  and  商品名='{$_GET['商品名']}';");
        $result_arr=mysqli_fetch_assoc($result);
        $用户名=$result_arr['用户名'];
        $picture=$result_arr['商品图片'];
        echo "<script LANGUAGE='javascript'>
                        if(confirm('确定要删除吗？')){
                            window.location='delcitiao.php?dname={$_GET['商店名']}&address={$_GET['地址']}&pname={$_GET['商品名']}&pic={$picture}&user={$用户名}';
                        }else{
                            window.location='javascript:window.history.back()';
                        }
                    </script>";
        echo "</center>";
        //跳转到浏览界面
//        header("Location:allresult.php?type=0");
        break;

    case 'delshangjia':
        echo "<center>";
        //验证
        $sql1="select  *  from  词条  where  商店名='{$_GET['商店名']}'  and  地址='{$_GET['地址']}'";
        $result1=mysqli_query($link,$sql1);
        $dateCount1=mysqli_num_rows($result1);
        $sql2="select  *  from  销售  where  商店名='{$_GET['商店名']}'  and  地址='{$_GET['地址']}'";
        $result2=mysqli_query($link,$sql2);
        $dateCount2=mysqli_num_rows($result2);
        if($dateCount1>0){
            echo "有此商店名、地址对应的词条存在，此商家信息无法删除！<br>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo " <a href='allresult.php?type=0'>浏览词条信息</a><br>";
        }
        if($dateCount2>0){
            echo "有此商店名、地址对应的销售记录存在，此商家信息无法删除！<br>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showxiaoshou.php'>浏览销售记录</a>";
        }
        //获取要删除的主码并拼装删除sql，执行
        if($dateCount1<=0 &&  $dateCount2<=0){
            echo "<script LANGUAGE='javascript'>
                        if(confirm('确定要删除吗？')){
                            window.location='delshangjia.php?name={$_GET['商店名']}&address={$_GET['地址']}';
                        }else{
                            window.location='javascript:window.history.back()';
                        }
                    </script>";

            //跳转到浏览界面
          //  header("Location:showshangjia.php");
        }
        echo "</center>";
        break;


    case 'delshangpin':
        echo "<center>";
        //验证
        $sql1="select  *  from  词条  where  商品名='{$_GET['商品名']}'";
        $result1=mysqli_query($link,$sql1);
        $dateCount1=mysqli_num_rows($result1);
        $sql2="select  *  from  销售  where  商品名='{$_GET['商品名']}'";
        $result2=mysqli_query($link,$sql2);
        $dateCount2=mysqli_num_rows($result2);
        if($dateCount1>0){
            echo "<h3>有此商品名对应的词条存在，此商品信息无法删除！</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='result.php'>删除词条信息</a>";
        }
        if($dateCount2>0){
            echo "<h3>有此商品名对应的销售记录存在，此商品信息无法删除！</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showxiaoshou.php'>删除销售记录</a>";
        }
        //获取要删除的主码并拼装删除sql，执行
        if($dateCount1<=0 &&  $dateCount2<=0){
            $sql="select  *  from  商品  where  商品名='{$_GET['商品名']}'";
            $result=mysqli_query($link,$sql);
            $result_arr=mysqli_fetch_assoc($result);  //解析出要修改的商品信息
            $picture=$result_arr['商品图片'];
            echo "<script LANGUAGE='javascript'>
                        if(confirm('确定要删除吗？')){
                            window.location='delshangpin.php?name={$_GET['商品名']}&pic={$picture}';
                        }else{
                            window.location='javascript:window.history.back()';
                        }
                    </script>";
            
            //跳转到浏览界面
//            header("Location:showshangpin.php?type=0");
        }
        echo "</center>";
        break;

    case 'delxiaoshou':
        echo "<center>";
        //1.验证
        $sql="select *  from  词条 where  商店名='{$_GET['商店名']}'  and  地址='{$_GET['地址']}'  and  商品名='{$_GET['商品名']}'";
        $result=mysqli_query($link,$sql);
        $dateCount=mysqli_num_rows($result);
        if($dateCount>0){
            echo "有此商店名、地址、商品名对应的词条存在，此销售信息无法删除！<br>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='allresult.php?type=0'>浏览词条信息</a>";
        }else{
            echo "<script LANGUAGE='javascript'>
                        if(confirm('确定要删除吗？')){
                            window.location='delxiaoshou.php?dname={$_GET['商店名']}&address={$_GET['地址']}&pname={$_GET['商品名']}';
                        }else{
                            window.location='javascript:window.history.back()';
                        }
                    </script>";

            //跳转到浏览界面
//            header("Location:showshangjia.php");
        }
        echo "</center>";
        break;

    case 'updatecitiao'://修改
        echo "<center>";
        //1.获取要修改的信息
        $旧商店名=$_POST['旧商店名'];
        $旧地址=$_POST['旧地址'];
        $旧商品名=$_POST['旧商品名'];
        $用户名=$_POST['用户名'];
        $商店名=$_POST['商店名'];
        $地址=$_POST['地址'];
        $商品名=$_POST['商品名'];
        $销售价格=$_POST['销售价格'];
        $pic=$_POST['oldpic'];

        $result=mysqli_query($link,"select  *  from  销售  where  商店名='{$商店名}' and  地址='{$地址}' and  商品名='{$商品名}';");
        $dateCount=mysqli_num_rows($result);
        if($dateCount<=0){
            $result1=mysqli_query($link,"select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}';");
            $dateCount1=mysqli_num_rows($result1);
            $result2=mysqli_query($link,"select  *  from  商品  where  商品名='{$商品名}';");
            $dateCount2=mysqli_num_rows($result2);
            if($dateCount1>0 && $dateCount2>0){
                echo "<h3>该商家没有销售此商品的记录！</h3>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showxiaoshou.php'>浏览销售信息</a>";
                echo "<br>";
            }else{
                if($dateCount1<=0){
                    echo "<h3>商店名或地址输入错误！</h3>";
                    echo "<a href='javascript:window.history.back()'>返回</a>";
                    echo "&nbsp;&nbsp;&nbsp";
                    echo "<a href='showshangjia.php'>浏览商家信息</a>";
                    echo "<br>";
                }

                if($dateCount2<=0){
                    echo "<h3>商品名不存在</h3>";
                    echo "<a href='javascript:window.history.back()'>返回</a>";
                    echo "&nbsp;&nbsp;&nbsp";
                    echo "<a href='showshangpin.php'>浏览商品信息</a>";
                    echo "<br>";
                }
            }
        }else{
            //3.判断有无图片上传
            //没有图片上传则使用默认图片
            if($_FILES['pic']['error']==4){
                echo "没有文件上传，将使用默认图片。<br>";
                $result=mysqli_query($link,"select  *  from  商品   where  商品名='{$商品名}';");
                $result_arr=mysqli_fetch_assoc($result);
                $pic=$result_arr['商品图片'];
            }else{  //有图片上传
                //执行上传
                $upinfo=uploadFile("pic","./uploads/");
                if($upinfo["error"]===false){
                    die("图片信息上传失败：".$upinfo["info"]);
                }else{
                    //上传成功
                    $pic="./uploads/".$upinfo["info"]; //获取上传成功的图片名
                    //4.有图片上传，执行缩放
//                imageUpdateSize("./uploads/".$pic,50,50);
                }
            }

            //5.执行修改
            $sql="update  词条 set 用户名='{$用户名}',商店名='{$商店名}',地址='{$地址}',商品名='{$商品名}',销售价格='{$销售价格}',商品图片='{$pic}'  where  商店名='{$旧商店名}' and  地址='{$旧地址}' and  商品名='{$旧商品名}'";
//        echo $sql;
            mysqli_query($link,$sql);

            //6.判断是否修改成功
            if(mysqli_affected_rows($link)>0){
                //若有图片上传,就删除老图片
                if($_FILES['pic']['error']!=4){
                    @unlink($_POST['oldpic']);
                }
                echo "修改成功!<br>";
            }else{
                echo "修改失败!<br>".mysqli_error($link);
            }
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='allresult.php?type=0'>查看词条信息</a>";
        }
        echo "</center>";
        break;

    case 'updateshangjia':
        echo "<center>";
        //1.获取要修改的信息
        $旧商店名=$_POST['旧商店名'];
        $旧地址=$_POST['旧地址'];
        $商店名=$_POST['商店名'];
        $地址=$_POST['地址'];
        $印象标签=$_POST['印象标签'];
        $口碑=$_POST['口碑'];

        //2.验证
        //判断是否有词条信息依赖此商家信息，则该商家主码信息无法修改
        $result=mysqli_query($link,"select  *  from  词条  where  商店名='{$旧商店名}'  and  地址='{$旧地址}';");
//        echo $sql="select  *  from  词条  where  商店名='{$旧商店名}'  and  地址='{$旧地址}''";
        $dateCount=mysqli_num_rows($result);
//        echo $dateCount;
        if($dateCount>0  &&  ((strcmp($商店名,$旧商店名))!=0 ||  strcmp($地址,$旧地址)!=0)){
            echo "<h3>有此商店名、地址对应的词条存在，此商家主要信息无法修改!</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='allresult.php?type=0'>浏览词条信息</a>";
        }else{
            $result1=mysqli_query($link,"select  *  from  商家  where  商店名='{$商店名}' and  地址='{$地址}';");
            $dateCount1=mysqli_num_rows($result1);
            if($dateCount1>0  &&  ((strcmp($商店名,$旧商店名))!=0  ||  strcmp($地址,$旧地址)!=0)){
                echo "<h3>该商家信息已经存在！</h3>";
            }else{
                $sql="update  商家 set 商店名='{$商店名}',地址='{$地址}',印象标签='{$印象标签}',口碑='{$口碑}'  where  商店名='{$旧商店名}' and  地址='{$旧地址}'";
//                echo $sql;
                mysqli_query($link,$sql);

                //6.判断是否修改成功
                if(mysqli_affected_rows($link)>0){
                    echo "修改成功<br>";
                }else{
                    echo "修改失败<br>".mysqli_error($link);
                }
            }
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showshangjia.php'>查看商家信息</a>";
        }
        echo "</center>";
        break;

    case 'updateshangpin':
        echo "<center>";
        //1.获取要修改的信息
        $旧商品名=$_POST['旧商品名'];
        $商品名=$_POST['商品名'];
        $商标=$_POST['商标'];
        $pic=$_POST['oldpic'];

        //2.验证
        $result=mysqli_query($link,"select  *  from  销售  where  商品名='{$旧商品名}';");
        $dateCount=mysqli_num_rows($result);
        if($dateCount>0  &&  strcmp($商品名,$旧商品名)!=0){
            echo "<center>";
            echo "<h3>有商家销售此商品,无法修改！</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showxiaoshou.php'>浏览销售信息</a>";
            echo "<br>";
            echo "</center>";
        }else{
            $sql1="select  *  from  商品  where  商品名='{$商品名}'";
            $result=mysqli_query($link,$sql1);
            $dateCount=mysqli_num_rows($result);
            if($dateCount>0){
                echo "<h3>该商品已经存在！</h3>";
            }else {
                //3.判断有无图片上传
                //没有图片上传则使用默认图片
                if ($_FILES['pic']['error'] == 4) {
                    echo "没有文件上传，将使用默认图片。<br>";
                    $pic = './img/default.jpg';
                } else {  //有图片上传
                    //执行上传
                    $upinfo = uploadFile("pic", "./uploads/");
                    if ($upinfo["error"] === false) {
                        die("图片信息上传失败：" . $upinfo["info"]);
                    } else {
                        //上传成功
                        $pic = "./uploads/" . $upinfo["info"]; //获取上传成功的图片名
                        //4.有图片上传，执行缩放
//                imageUpdateSize("./uploads/".$pic,50,50);
                    }
                }

                //5.执行修改
                $sql = "update  商品 set 商品名='{$商品名}',商标='{$商标}',商品图片='{$pic}'  where  商品名='{$旧商品名}'";
//            echo $sql;
                mysqli_query($link, $sql);

                //6.判断是否修改成功
                if (mysqli_affected_rows($link) > 0) {
                    //若有图片上传,就删除老图片
                    if ($_FILES['pic']['error'] != 4) {
                        @unlink($_POST['oldpic']);
                    }
                    echo "修改成功<br>";
                } else {
                    echo "修改失败" . mysqli_error($link);
                }
            }
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='showshangpin.php?type=0'>查看商品信息</a>";
        }
        echo "</center>";
        break;

    case 'updatexiaoshou':
        echo "<center>";
//        print_r($_POST);
        //1.获取要修改的信息
        $旧商店名=$_POST['旧商店名'];
        $旧地址=$_POST['旧地址'];
        $旧商品名=$_POST['旧商品名'];
        $商店名=$_POST['商店名'];
        $地址=$_POST['地址'];
        $商品名=$_POST['商品名'];
        $销售价格=$_POST['销售价格'];

        //2.验证
        //判断是否有词条信息依赖此销售信息，则该销售主码信息无法修改
        $result=mysqli_query($link,"select  *  from  词条  where  商店名='{$旧商店名}'  and  地址='{$旧地址}'  and  商品名='{$旧商品名}';");
        $dateCount=mysqli_num_rows($result);
        $result2=mysqli_query($link,"select  *  from  商家  where  商店名='{$商店名}'  and  地址='{$地址}';");
        $dateCount2=mysqli_num_rows($result2);
        if($dateCount2<=0){
            echo "<center>";
            echo "<h3>没有对应的商家信息存在！<h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='addshangjia.php'>添加商家信息</a>";
            echo "</center>";
        }
        if($dateCount>0  &&  ((strcmp($商店名,$旧商店名)!=0) ||  (strcmp($地址,$旧地址)!=0)  ||  (strcmp($商品名,$旧商品名)!=0))){
            echo "<center>";
            echo "<h3>有此商店名、地址、商品名对应的词条存在，此销售记录主要信息无法修改!</h3>";
            echo "<a href='javascript:window.history.back()'>返回</a>";
            echo "&nbsp;&nbsp;&nbsp";
            echo "<a href='allresult.php?type=0'>浏览词条信息</a>";
            echo "</center>";
        }else{
            if($dateCount2>0){
                $result1=mysqli_query($link,"select  *  from  销售  where  商店名='{$商店名}' and  地址='{$地址}'  and  商品名='{$商品名}';");
                $dateCount1=mysqli_num_rows($result1);
                if($dateCount1>0  &&  ((strcmp($商店名,$旧商店名)!=0)  ||  strcmp($地址,$旧地址)!=0)  ||  (strcmp($商品名,$旧商品名)!=0)){
                    echo "<h3>该销售记录已经存在！</h3>";
                }else{
                    $sql="update  销售 set 商店名='{$商店名}',地址='{$地址}',商品名='{$商品名}',销售价格='{$销售价格}'  where  商店名='{$旧商店名}' and  地址='{$旧地址}'  and  商品名='{$旧商品名}'";
//                echo $sql;
                    mysqli_query($link,$sql);

                    //6.判断是否修改成功
                    if(mysqli_affected_rows($link)>0){
                        echo "修改成功<br>";
                    }else{
                        echo "修改失败".mysqli_error($link);
                    }
                }
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showxiaoshou.php'>查看销售信息</a>";
            }
        }
        echo "</center>";
        break;

    case "updateyonghu":
        echo "<center>";
        //1.获取要修改的信息
        $用户编号=$_POST['id'];
        $用户名=$_POST['用户名'];
        $旧密码=md5($_POST['旧密码']);
        $新密码=md5($_POST['新密码']);
        $pic=$_POST['oldpic'];
        if(strlen($_POST['新密码'])<6 || strlen($_POST['新密码'])>20 || !ctype_alnum($_POST['新密码'])){
            echo "<script> alert('密码不符合要求，可以为英文大小写和数字，且长度为6-20个字符');history.back(-1);</script>;die;";
        }else if(strlen($用户名)<5 || strlen($用户名)>25 || !ctype_alnum($用户名)){
            echo "<script> alert('用户名不符合要求，可以为英文大小写和数字，且长度为5-25个字符');history.back(-1);</script>;die;";
        }else {
            //2.验证
            $result = mysqli_query($link, "select  *  from  用户  where  用户编号='{$用户编号}'  and  密码='{$旧密码}';");
            $dateCount = mysqli_num_rows($result);
            if ($dateCount <= 0) {
                echo "<center>";
                echo "<h3>原始密码输入错误！</h3>";
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='edityonghu.php'>重新修改</a>";
                echo "</center>";
            } else {
                //3.判断有无图片上传
                //没有图片上传则使用默认图片
                if ($_FILES['pic']['error'] == 4) {
                    echo "没有文件上传，将使用默认图片。<br>";
                    $pic = './login/img/01.jpg';
                } else {  //有图片上传
                    //执行上传
                    $upinfo = uploadFile("pic", "./uploads/");
                    if ($upinfo["error"] === false) {
                        die("图片信息上传失败：" . $upinfo["info"]);
                    } else {
                        //上传成功
                        $pic = "./uploads/" . $upinfo["info"]; //获取上传成功的图片名
                        //4.有图片上传，执行缩放
//                imageUpdateSize("./uploads/".$pic,50,50);
                    }
                }

                //5.执行修改
                $sql = "update  用户 set 用户名='{$用户名}',密码='{$新密码}',用户头像='{$pic}'  where  用户编号='{$用户编号}'";
//            echo $sql;
                mysqli_query($link, $sql);

                //6.判断是否修改成功
                if (mysqli_affected_rows($link) > 0) {
                    //若有图片上传,就删除老图片
                    if ($_FILES['pic']['error'] != 4) {
                        @unlink($_POST['oldpic']);
                    }
                    echo "修改成功<br>";
                } else {
                    echo "修改失败" . mysqli_error($link);
                }
                echo "<a href='javascript:window.history.back()'>返回</a>";
                echo "&nbsp;&nbsp;&nbsp";
                echo "<a href='showshangpin.php?type=0'>查看商品信息</a>";
            }
        }
        echo "</center>";
        break;
}

//四、关闭数据库
mysqli_close($link);