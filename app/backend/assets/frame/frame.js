//初始化执行函数
$(function() {
	//用户信息
	userInfo();
	//左侧菜单
	leftMenuToggle();
	//锁屏按钮
	bindLockScreen();
	//快捷菜单
	bindQuickMenu();
}).keydown(function(event) {
	//快捷键，ESC快速退出
	if(event.keyCode == 27) {
		window.top.location.href = CONFIG.com.logoutUrl;
	}
});

//用户信息
function userInfo()
{
	$(".user-panel").mouseover(function() {
		$(".user-panel .arrow").addClass("on");
		$(".user-panel .panel").fadeIn(200);
	}).mouseout(function() {
		var hidequcikmenu = setTimeout('$(".user-panel .panel").fadeOut(200);$(".user-panel .arrow").removeClass("on");',100);
		$(this).mouseover(function(){clearTimeout(hidequcikmenu);});
	});
}

//左侧菜单
function leftMenuToggle()
{
	$("#logo").click(function(){
		if($(this).attr("class") == "logo") {
			$(".left").animate({width:"0"},300,function(){$(this).hide()});
			$(".right").animate({left:"0"},300);
			$(this).addClass("logo-on");
		} else {
			$(".left").show().animate({width:"218px"},300);
			$(".right").animate({left:"219px"},300);
			$(this).removeClass("logo-on");
		}
	});
}

//快捷菜单
function bindQuickMenu() {
	$(".quick").mouseover(function() {
		$(".quick .quick-nav").addClass("on");
		$(".quick .quickmenu").fadeIn(200);
	}).mouseout(function() {
		var hidequcikmenu = setTimeout('$(".quick .quickmenu").fadeOut(200);$(".quick .quick-nav").removeClass("on");',100);
		$(this).mouseover(function(){clearTimeout(hidequcikmenu);});
	}).find("a").click(function() {
		$(this).blur();
		$(".quick .quickmenu").fadeOut(100);
	});
}






//锁屏函数
function bindLockScreen()
{
	$(".lock-screen").click(function() {
		$(".lock-screen-bg").show();
		$.get("lockscreen_do.php",{action:"lock"});
	});
}
//锁屏密码
function CheckPwd()
{
	if($(".lock-screen-bg #password").val() == '') {
		$(".lock-screen-bg .note").html("请输入解锁密码！");
		setTimeout('$(".lock-screen-bg .note").html("&nbsp;")',5000);
	} else {
		$.get("lockscreen_do.php",{action:"check",password:$("#password").val()},function(data) {
			if(data == true) {
				$(".lock-screen-bg").fadeOut(150);
				$(".lock-screen-bg #password").val("");
			} else {
				$(".lock-screen-bg .note").html("密码错误，请重新输入！");
				setTimeout('$(".lock-screen-bg .note").html("&nbsp;")',5000);
			}
		});
	}
}
//验证授权
function GetAuth()
{
	$.ajax({
		async    : false,
		url      : "index.php?url="+ url +"&callback=?",
		type     : "GET",
		dataType : "jsonp",
		jsonp    : "jsoncallback",
		timeout  : 5000,

		success:function(data){
			var jsonStr = JSON.stringify(data);
			$.ajax({
				type:'GET',
				url:'do.php?action=updataauth&jsonStr='+ jsonStr,
				beforeSend: function(){},
				success:function(){}
			})

			if(data.status == "OK"){
				$(".authUser").show();
			}else{
				$(".authUser").hide();
			}
		}
	});
}