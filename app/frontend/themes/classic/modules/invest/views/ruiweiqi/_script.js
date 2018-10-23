//设置背景
// 20170607-01_01

function setBackground(imgsrc = "20170607-01.jpg") {
    imgsrc = "images/inves/ruiweiqi/" + imgsrc;
    $('body').css({
        'background': "url(" + imgsrc + ")",
        'background-position': "center",
        'background-repeat': 'no-repeat',
        'background-size': '100% 100%',
    });
}
var _problem_page = 0;
var _problem_daan = {};
var _man_xuanze = 0;

function index_page_11() {
    var phone = $('.phone-val').val();
    var url = $('.post-problem').val();
    if (phone == '') {
        alert('请填写您的手机号');
        return false;
    }
    if (!(/^1[34578]\d{9}$/.test(phone))) {
        alert("手机号码有误，请重新填写");
        return false;
    }
    $.post(url, { phone: phone, problem: _problem_daan }, function(res) {
        if (res == 1) {
            var msg = "您已经填写过了";
        } else {
            var msg = "谢谢参与";
        }
        setBackground('end.jpg');
        var html = '<div class="end"><h3 class="center-block">' + msg + '</h3></div>';
        $('.zhuti').html(html);
    });
}

function index_page_10() {
    setBackground('phone-back.jpg');
    var html = '<div class="phone"><label class="center-block"><input class="phone phone-val" type="text" size="20" placeholder="请输入您的手机号"/><br/>\
    <img class="index-page-10" width="30%" src="images/inves/ruiweiqi/20170607-01_01.png"/></label></div>';
    $('.zhuti').html(html);
}

function index_page_9() {
    var _imgsrc = '';
    if (_man_xuanze == 0) {
        _imgsrc = "aijiyanhou";
    } else if (_man_xuanze == 1) {
        _imgsrc = 'wangfei';
    } else if (_man_xuanze == 2) {
        _imgsrc = 'yuedan';
    } else if (_man_xuanze == 3) {
        _imgsrc = 'ruidian';
    }
    setBackground(_imgsrc + '.jpg');
    var html = '<div class="dibu-xiayibu" ><a class="index-page-9"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/><br/></a></div>';
    $('.zhuti').html(html);

}

function index_page_8() {
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                _problem_page += 1;
                flag = 0;
                _man_xuanze = $(this).val();
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    var html = "<div class='zhubao'><h4>揭晓答案前先来了解下瑞薇琪的品牌故事吧：</h4>\
<p>古罗马时期，以美貌和智慧征服世界的埃及艳后克利欧佩特拉，不论身材与皮肤，看上去仍和少女一样，罗马帝国的两任总统均为她倾倒！\
据称，埃及艳后每天都要用死海泥涂抹全身，并用死海矿物温泉冲洗，让水中的矿物质充分滋养肌肤。\
经科学家证实，死海泥、死海盐矿物质含量高达 60% ，是世界上其他海泥矿物含量的十倍以上，其中有 24种矿物质是死海泥盐所独有的。\
所以她的皮肤始终如少女般细腻柔润有弹性。<br/><br/>\
这以后法国科学家成功破解了死海矿物的美容秘密，突破性萃取了高浓度的死海活性矿物 （DSM）成分， 由此而推出了首个以死海活性矿物作为主要成分的护肤品牌——R̛QUEEN瑞薇琪。</p>";
    html += '<div class="dibu-xiayibu" style="bottom: 10%;"><a class="index-page-8"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/><br/></a></div>';
    $('.zhuti').html(html);
}

function index_page_7() {
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                _problem_page += 1;
                flag = 0;
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    var html = "<div class='zhubao'><h4>9.今晚你将选择的舞伴是？</h4>";
    html += '<label><input type="radio" value="0" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/ruoma.png"/></br>罗马大帝</label>\
    <label><input type="radio" value="1" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/weilian.png"/><br/>威廉王子</label>\
    <label><input type="radio" value="2" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/apudula.png"/><br/>阿卜杜拉王子</label>\
    <label><input type="radio" value="3" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/kelisi.png"/><br/>克里斯·欧尼尔</label>';
    html += '<div class="dibu-xiayibu"><a class="index-page-7"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/><br/></a></div>';
    $('.zhuti').html(html);
}

function index_page_6() {
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                _problem_page += 1;
                flag = 0;
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    var html = "<div class='zhubao'><h4>8.你的私人护肤师，为您研制了天蚕丝的面膜，觉得会在下面哪个盒子里？</h4>";
    html += '<label style="width:100%;"><input type="radio" value="0" class="xuanze" name="xuanze"><img width="80%" src="images/inves/ruiweiqi/tiansimianmo1.jpg"/></label>\
    <label style="width:100%;"><input type="radio" value="1" class="xuanze" name="xuanze"><img width="80%" src="images/inves/ruiweiqi/tiansimianmo2.jpg"/></label>';
    html += '<div class="dibu-xiayibu"><a class="index-page-6"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/></a></div>';
    $('.zhuti').html(html);
}

function index_page_5() {
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                _problem_page += 1;
                flag = 0;
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    var html = "<div class='zhubao'><h4>7.你的私人护肤师献上了来自约旦的神奇的死海泥膜给您做清洁SPA，你觉得会在下面哪个盒子里？</h4>";
    html += '<label style="width:100%;"><input type="radio" value="0" class="xuanze" name="xuanze"><img width="80%" src="images/inves/ruiweiqi/nimo1.jpg"/></label>\
    <label style="width:100%;"><input type="radio" value="1" class="xuanze" name="xuanze"><img width="80%" src="images/inves/ruiweiqi/nimo2.jpg"/></label>';
    html += '<div class="dibu-xiayibu"><a class="index-page-5"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/></a></div>';
    $('.zhuti').html(html);
}

function index_page_4() {
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                flag = 0;
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    setBackground('6.jpg');
    var html = "<div class='zhubao'><h4>6.今天早上外国使臣进贡了一项珠宝，给你镶嵌在新制作的皇冠上，他进贡的是：</h4>";
    html += '<label><input type="radio" value="0" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/zhenzhu.png"/><br/>珍珠</label>\
    <label><input type="radio" value="1" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/zuanshi.png"/><br/>钻石</label>\
    <label><input type="radio" value="2" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/hongbaoshi.png"/><br/>红宝石</label>\
    <label><input type="radio" value="1" class="xuanze" name="xuanze"><img width="100%" src="images/inves/ruiweiqi/zishuijing.png"/><br/>紫水晶</label>\
    </div>';
    html += '<div class="dibu-xiayibu"><a class="index-page-4"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/></a></div>';
    $('.zhuti').html(html);
}
//在这里作为问答阶段开始了
function index_page_3() {
    //在这里判断上一道题是否选择了，否则不给跳转
    var xuanze = $('.xuanze');
    if (xuanze.length != 0) {
        var flag = 1;
        xuanze.each(function() {
            if ($(this).is(':checked')) {
                flag = 0;
                _problem_daan[_problem_page] = $(this).val();
            }
        });
        if (flag) { alert('请做出选择'); return false; }
    }
    // 首先拿取问题
    var url = $(".problem").val();
    $.get(url, function(res) {
        var data = $.parseJSON(res);
        if (data['code'] == 200) {
            var problem = data['problem'];
            //请求成功，首先更换背景图片
            _problem_page += 1;
            setBackground('20170607-02.jpg');
            //这是一个完整的问题，
            var title = _problem_page + ". " + problem[_problem_page]['title'];
            var xuanze = problem[_problem_page]['xuanze'];
            var end = problem[_problem_page]['end'];
            if (end) { var next_class = "index-page-3" } else { var next_class = "index-page-2" }
            //在这里拼接html
            var html = "<div class='problem-main center-block' style='text-align:center'><h4>" + title + "</h4>";
            for (var i = 0; i < xuanze.length; i++) {
                html += '<label><input type="radio" id="xuanze' + i + '"  value="' + i + '" class="xuanze" name="xuanze">' + xuanze[i] + '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                if (i % 2 == 1) {
                    html += "<br/>";
                }
            }
            html += "</div>";
            html += '<div class="dibu-xiayibu"><a class="' + next_class + '"><img width="90%"  src="images/inves/ruiweiqi/20170607-01_02.png"/></a></div>';
            $('.zhuti').html(html);
        }
    });
}

// function index_page_2() {
//     $('body').css('background', '#fff');
//     var html = "<div class='center-block' style='text-align:center'><h3>敢不敢测测你是哪国的王室贵族？我居然是她···</h3></div>";
//     html += "<dl><dt>前言：</dt><dd class=lead>近几年国产古装剧可谓是一波接一波，将古装皇室之争推向热潮，更加夺人眼球的非穿越剧莫属，捧红了不少主角不说，最深入人心的是观众对过去朝代的好奇甚至想亲身参与，从而产生了编剧们撰写穿越的情节！\
// 那么作为古装剧粉丝的你，是不是也幻想着自己能同主角般穿越古代，做皇妃？做公主？还是平民百姓？国内还是国外？假如你穿越了，你会成为谁呢？现在只要做个小测试，就能知道啦！\
// 还有伊思蜗牛BB霜免费赠送哦。想想是不是还有点小兴奋呢！</dd></dl>";
//     html += '<div class="center-block" style="text-align:center"><button type="button" style="color:#000" class="btn btn-default btn-lg btn-block back-ming index-page-3">继续</button></div>';
//     $('.zhuti').html(html);
// }

function index_page_jieshao() {
    $('body').css('background', '#fff');
    var html = "<img style='width:100%'  src='images/inves/ruiweiqi/20170607-06.jpg'/>";
    html += '<div class="dibu center-block"><a class="index-page-2"><img width="80%" src="images/inves/ruiweiqi/20170607-01_04.png" /></a></div>';
    $('.zhuti').html(html);
}

function index_page() {
    var html = '<div class="dibu-left"><a class="index-page-jieshao"><img width="80%" src="images/inves/ruiweiqi/20170607-01_03.png"/></a></div>';
    html += '<div class="dibu-right"><a class="index-page-2"><img width="80%" src="images/inves/ruiweiqi/20170607-01_04.png"/></a></div>'
    $('.zhuti').html(html);
}


//介绍点击
$('.zhuti').on('click', '.index-page-jieshao', function() {
    index_page_jieshao();
});
//处理下一页的点击事件
$('.zhuti').on('click', '.index-page-2', function() {
    index_page_3();
});
//处理下一页的点击事件
$('.zhuti').on('click', '.index-page-3', function() {
    index_page_4();
});
//处理选择宝石页面
$('.zhuti').on('click', '.index-page-4', function() {
    index_page_5();
});
//处理选择面膜页面
$('.zhuti').on('click', '.index-page-5', function() {
    index_page_6();
});
//处理选择第二个面膜页面
$('.zhuti').on('click', '.index-page-6', function() {
    index_page_7();
});
//选择舞伴
$('.zhuti').on('click', '.index-page-7', function() {
    index_page_8();
});
//看完介绍
$('.zhuti').on('click', '.index-page-8', function() {
    index_page_9();
});
//看完人物展示，去往填写手机号页面
$('.zhuti').on('click', '.index-page-9', function() {
    index_page_10();
});
//填写完手机，准备整理数据发送
$('.zhuti').on('click', '.index-page-10', function() {
    index_page_11();
});
setBackground();
index_page();