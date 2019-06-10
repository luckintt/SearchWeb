$(document).ready(function(){
//获取搜索框中的焦点
    $(".search-input").focusin(function() {
      $(".tar-slide").stop().slideDown(350).css('display','block');
      $(".down").slideUp(300);
    });
//点击感叹号事件
$("a.more").hover(
function(){
    $(this).next().stop().fadeTo(250,1);
},
function(){
    $(this).next().stop().fadeOut(200);
});
//高亮提示
$("ul.tar li").click(function(){
    $("*").removeClass("H-light");
    $(this).addClass("H-light");
    $(this).children().addClass("H-light");
});
});
