var marqueeString = new Array();
	marqueeString[0] = '<span>[官方开发消息]</span><a href="http://turen2.com/" target="_blank">亲爱的客户您好，系统v1.5.0版即将上线，敬请期待...</a><br />';
	marqueeString[1] = '<span>[官方开发消息]</span>为提高我们的服务质量，您可以通过我们的 <a href="http://baidu.com" target="_blank">官网论坛</a>反馈问题了 <br />';
	marqueeString[2] = '<span>[官方开发消息]</span>营销功能才是核心，如何做到系统与百度、360等推广渠道深度整合？ <br />';

var marqueeInterval = new Array();
var marqueeId       = 0;
var marqueeDelay    = 5000;
var marqueeSpeed    = 20;
var marqueeHeight   = 25;


function InitMarquee()
{
	var str      = marqueeString[0];
	var newsArea = document.getElementById("shownews");
	newsArea.className = "";
	newsArea.innerHTML = '<div id="marqueeBox" style="overflow:hidden;height:'+marqueeHeight+'px" onmouseover="clearInterval(marqueeInterval[0])" onmouseout="marqueeInterval[0]=setInterval(\'StartMarquee()\',marqueeDelay)"><div>'+str+'</div></div>';
	marqueeId++;
	marqueeInterval[0] = setInterval("StartMarquee()", marqueeDelay);
}

function StartMarquee()
{
	var str = marqueeString[marqueeId];
	marqueeId++;

	if(marqueeId >= marqueeString.length)
	{
		marqueeId = 0;
	}

	if(marqueeBox.childNodes.length == 1)
	{
		var NextLine = document.createElement('div');
		NextLine.innerHTML = str;
		marqueeBox.appendChild(NextLine);
	}

	else
	{
		marqueeBox.childNodes[0].innerHTML = str;
		marqueeBox.appendChild(marqueeBox.childNodes[0]);
		marqueeBox.scrollTop = 0;
	}

	clearInterval(marqueeInterval[1]);
	marqueeInterval[1] = setInterval("scrollMarquee()", marqueeSpeed);
}

function scrollMarquee()
{
	marqueeBox.scrollTop++;
	if(marqueeBox.scrollTop % marqueeHeight == (marqueeHeight-1))
	{
		clearInterval(marqueeInterval[1]);
	}
}

InitMarquee();
