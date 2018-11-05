//返回顶部
$(function () {
    $(".tui-content").bind('scroll resize', function () {
    	var scrolltop = $(".tui-content").scrollTop();
        if (scrolltop > "255") {
            $("#gotop").fadeIn(100)
        } else {
            $("#gotop").fadeOut(100)
        }
    });
    $("#gotop").unbind('click').click(function () {
        $(".tui-content").animate({scrollTop: "0px"}, 1000)
    });
    
    //生成二维码
    setTimeout(function(){
		$('#wap-qrcode').html('').qrcode($('meta[name="current-url"]').attr('content'));
	},500);
});

//字体自适应
$(window).resize(function(){
	document.documentElement.style.fontSize =document.documentElement.clientWidth/750*40 +"px";
});




