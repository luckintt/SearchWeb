<html>
<head>
    <title>乐淘优选网</title>
    <script type="text/javascript" src="jquery-2.1.3.min.js" ></script>
</head>
<body>
<center>
    <?php
        include_once "common.php";
    ?>
    <h3>创建商家信息</h3>
    <form action="action.php?action=addshangjia" enctype="multipart/form-data" method="post" >
        <table border="0"  width="400">
            <tr>
                <td align="right">商店名：</td>
                <td><input type="text"  name="商店名" /></td>
            </tr>
            <tr>
                <td align="right">地址：</td>
                <td><input type="text"  name="地址" /></td>
            </tr>
            <?php
                if(!isset($_COOKIE["utype"]) || $_COOKIE["utype"]!=1) {
                    echo "<tr>";
                    echo "<td align = \"right\" > 印象标签：</td >";
            // 1       echo "<td ><input type = \"text\" id = \"effect\" name = \"印象标签\" placeholder = \"请输入十个以内的汉字\"/></td >";
                    echo "<td ><textarea id = \"effect\" name = \"印象标签\" placeholder = \"请输入一百字以内的商家印象\" rows='5' cols='22' width='30%' maxlength='100'/></textarea></td >";
                    echo "</tr >";
                    echo "<tr >";
                    echo "<td align = \"right\" > 口碑：</td >";
                    echo "<td ><input type = \"text\"  name = \"口碑\" id = \"koubei\"  placeholder = \"请输入0到100的整数\" /></td >";
                    echo "</tr >";
                }
            ?>
            <tr >
                <td colspan = "2" align = "center" >
                    <?php
                    if(!isset($_COOKIE["utype"]) || $_COOKIE["utype"]==1) {
                    ?>
                        <input type = "submit" id = "submit" value = "添加" />&nbsp;&nbsp;&nbsp;
                    <?php
                    }
                    else {  //用户添加商家印象
                    ?>
                         <input type="button" id="submit" value="添加" onclick="checkit();"/>&nbsp;&nbsp;&nbsp;
                    <?php
                    }
                    ?>
                        <input type = "reset"  value = "重置" />
                 </td >
             </tr >

        </table>
    </form>
</center>
<script type="text/javascript">

    function checkit () {
        var koubei = document.getElementById("koubei").value;
        var effect = document.getElementById("effect").value;
        if ((koubei != "" ? (koubei >= 0 && koubei <= 100):false) && (effect != "" ? (effect.length <=100):false)) {
            $("input[id = 'submit']").attr({
                type:"submit"
            });
        }else{
            alert("输入的信息有误");
        }
    }
</script>
</body>
</html>