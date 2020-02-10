<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\LayerAsset;
use app\assets\Swiper3Asset;
use app\assets\ValidationAsset;
use common\models\account\Inquiry;

$this->topTitle = '免费报价';

$css = <<<EOF1
.online-banner{
	margin-top: 50px;
	padding: 0.25rem;
}
.online-main{
	padding:0 0.25rem;
}
.online-main .online-mainbox{
	padding: 0 0.22rem 0.3rem;
	border: 1px solid #dfdfdf;
	border-radius: 10px;
	box-shadow: 0 0 0.2rem #ccc;
}
.online-title{
	height: 0.6rem;
	display: flex;
	justify-content: center;
	align-items: center;
}
.online-title span{
	display: block;
	width: 1.36rem;
	height: 1px;
	background-color: #dedede;
}
.online-title p{
	font-size: 0.25rem;
	font-family: "Microsoft YaHei";
	color: #333;
	margin: 0 0.6rem;
}
.online-price .online-pricebox{
	width: 100%;
	padding: 0 0.36rem;
	height: 1.4rem;
	background:url(../images/yaqiao/pricebg.png) no-repeat center;
	background-size: 100% 100%;
	position: relative;
}
.online-price .online-pricebox p{
	font-size: 0.25rem;
	color: #333333;
	text-align: right;
	position: absolute;
	right: 0.3rem;
	bottom: 0.3rem;
}
.online-price .online-pricebox p i{
	display: block;
	font-size: 0.25rem;
	color: #333333;
	width: 0.25rem;
	height: 0.25rem;
}
.online-price .online-pricelist{
	height: 1rem;
	border: 1px solid #e2e2e2;
	border-top: none;
	border-radius: 5px;
	box-sizing: border-box;
}
.online-price .online-pricelist ul{
	overflow: hidden;
	padding-top: 0.1rem;
}
.online-price .online-pricelist ul li{
	width: 50%;
	float: left;
	font-size: 0.25rem;
	color: #1B1D1D;
	text-align: center;
	line-height: 0.4rem;
}
.online-price .online-pricelist ul li span{
	color: #666666;
}
.online-ipt{
	margin-top: 0.25rem;
}
.online-iptbox{
	width: 100%;
	height: 0.98rem;
	margin-bottom: 0.33rem;
	position: relative;
}
.online-iptbox p.error {
    font-size: .2rem;
    color: #ff362b;
}
.online-iptbox input{
	width: 100%;
	height: 100%;
	border: none;
	outline: none;
	background-color: #e8e8e8;
	border-radius: 8px;
	padding: 0 0.32rem;
	font-size: 0.26rem;
	color: #000000;
}
.online-iptbox span{
	width: 100%;
	height: 100%;
	background-color: #e8e8e8;
	border-radius: 8px;
	padding: 0 0.32rem;
	font-size: 0.26rem;
	color: #000000;
	display:block;
	line-height: 0.98rem;
}
.online-iptbox i{
	display: block;
	font-size: 0.27rem;
	color: #000000;
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	-webkit-transform: translateY(-50%);
	-moz-transform: translateY(-50%);
	-ms-transform: translateY(-50%);
	-o-transform: translateY(-50%);
	right: 0.3rem;
}

.online-hide{
	width: 100%;
	overflow: hidden;
	z-index: 99999 !important;
	padding:0.3rem;
	background-color: #fff;
	border-bottom:1px solid #ccc;
	display: none;
}
.online-hide h3{
	font-size: 0.3rem;
	line-height: 0.6rem;
	overflow: hidden;
	margin: 0;
	color: #101010;
	background-color:#F9F9F9 ;
}
.online-hide h3 span{
	display: block;
	width: 0.06rem;
	height: 0.3rem;
	margin: 0.15rem 0;
	background-color: #ff6f20;
	float: left;
	margin-right: 0.2rem;
}
.online-hide .online-list{
	overflow: hidden;
}
.online-hide ul{
	float: left;
	width: 25%;
	margin: 0;
}
.online-hide ul li{
	text-align: center;
	margin: 0.1rem 0.07rem;
}
.online-hide ul li a{
	display: block;
	text-align: center;
	line-height: 0.6rem;
	font-size: 0.2rem;
	color: #1B1D1D;
	border-radius: 3px;
	background-color: #f4f4f4;
}
.online-hide ul .myhidecolor a{
	background-color: #ff6f20;
	color: #fff;
}

.online-iptbox #online-btn{
	background-color: #ff6f20;
	color: #fff;
	font-size: 0.32rem;
	box-shadow: 2px 2px 3px -1px #afafaf;
}
.online-iptbox label{
	display: block;
	font-size: 0.2rem;
	color: #ff362b;
	text-align: center;
	line-height: 0.6rem;
}
.mymain{
	padding: 0 0.25rem;
	display: flex;
	justify-content: center;
	margin-top: 0.9rem;
}
.mymain img{
	width: 6.67rem;
	height: 10.14rem;
}
.online-last{
	padding: 0 0.25rem 0.8rem;
	margin-top: 0.4rem;
}
.online-last p{
	font-size: 0.2rem;
	color: #a2a2a2;
	text-align: center;
	line-height: 0.4rem;
	margin: 0;
}
.online-totop{
	width: 100%;
	padding: 0 0.5rem;
	margin-top: 0.4rem;
}
.online-totop a{
	display: block;
	width: 100%;
	height: 0.8rem;
	font-size: 0.24rem;
	color: #fff;
	text-align: center;
	line-height: 0.8rem;
	background-color: #ff6f20;
	border-radius: 10px;	
}
.clearfix{
	overflow: hidden;
	margin-right: 0.2rem;
}
.clearfix:before{
	content: '\0020';
	display: block;
	height: 0;
	overflow: hidden;
}
.clearfix:after{
	clear: both;
	content: '\0020';
	display: block;
	height: 0;
	overflow: hidden;
}

.num-window div{
	float: right;
	width: 0.45rem;
	height: 1.4rem;
	margin: 0 0.05rem;
}
.num-window div img{
	width: 100%;
	margin: 0.25rem 0;
	width: 0.45rem;
	height: 0.9rem;
}
EOF1;
$this->registerCss($css);

Swiper3Asset::register($this);
LayerAsset::register($this);
ValidationAsset::register($this);
$js = <<<EOF2
var number_time = 0;
function rangeRandom(minnum,maxnum){
    return Math.floor(minnum+Math.random()*(maxnum - minnum +1));
}
function changeNum(time){
    var zbj;
    var i;
    number_time = setInterval(function(){
        zbj = rangeRandom(10000,200000)+'';
        $('.num-window div').find('img').hide();
        var str1 = zbj.length-1;
        for (var i = str1; i>=0; i--) {
            $('.num-window div').eq(str1-i).find('img').eq(zbj[i]).show();
        }
    },time)
}

$(function(){
    changeNum(400);
});

//下单跳动效果
var callOrderSwiper = new Swiper('.online-mainbox .swiper-container', {
    direction: 'vertical',//纵向模式
    loop: true,//循环
    autoplay: 2000,//自动播放且间隔为2秒
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
}); 

var validator = $('form.online-form').validate({
	rules: {
        name: {
            required: true,
        },
        phone: {
            required: true,
            isPhone: true,
        },
    },
	messages: {
        name: {
            required: '<em class="iconfont jia-close_b"></em> 称呼必填'
        },
        phone: {
            required: '<em class="iconfont jia-close_b"></em> 手机号码必填',
            isPhone: '<em class="iconfont jia-close_b"></em> 号码格式有误'
        },
    },
    errorElement: 'p',
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	},
	submitHandler: function(form) {
        layer.open({
            type: 1
            ,title: false
            //,title: '安全验证'
            ,anim: -1//无动画
            //,shade: false//无背景遮布
            ,area: ['5rem', '3.6rem'] //宽高
            ,content: $('#fllow-wrap-tpl').html(),//模板
        });
        
        //ajax提交
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            dataType: 'json',
            context: $(form),
            cache: false,
            data: $(form).serialize(),
            success: function(res) {
                if (res['state']) {
                    //
                } else {
                    //
                }
            }
        });
        
        form.reset();
        return false;
    }  
});
EOF2;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');
?>

<div class="online-banner" style="margin-top: 0.9rem;">
    <a href="<?= Url::to(['/online/price']) ?>">
        <img src="<?= $webUrl ?>images/yaqiao/banner.png">
    </a>
</div>

<div class="online-main">
    <div class="online-mainbox">
        <div class="online-title">
            <span></span>
            <p>您的租赁预算</p>
            <span></span>
        </div>
        <div class="online-price">
            <div class="online-pricebox">
                <p>
                    <i>元</i>
                </p>
                <div class="num-window clearfix clear">
                    <div class="ge">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n0.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n1.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n2.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n3.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n4.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n5.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n6.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n7.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n8.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n9.png">
                    </div>
                    <div class="shi">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n0.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n1.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n2.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n3.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n4.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n5.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n6.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n7.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n8.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n9.png">
                    </div>
                    <div class="bai">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n0.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n1.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n2.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n3.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n4.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n5.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n6.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n7.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n8.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n9.png">
                    </div>
                    <div class="qian">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n0.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n1.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n2.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n3.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n4.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n5.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n6.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n7.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n8.png">
                        <img src="<?= $webUrl ?>images/yaqiao/zxbj_n9.png">
                    </div>
                </div>
            </div>
            <div class="online-pricelist">
                <ul>
                    <li>人工费：<span>？</span>元</li>
                    <li>柴油费：<span>？</span>元</li>
                    <li>过路费：<span>？</span>元</li>
                    <li>税费：<span>？</span>元</li>
                </ul>
            </div>
        </div>
        <div class="online-ipt">
            <?= $form = Html::beginForm(['/online/price'], 'POST', ['class' => 'online-form']) ?>
                <div class="online-iptbox">
                    <?= Html::textInput('name', '', ['placeholder' => '请输入您的称呼']) ?>
                    <i>先生/女士</i>
                </div>
                <div class="online-iptbox">
                    <?= Html::textInput('phone', '', ['placeholder' => '输入号码，我们会及时联系您的手机']) ?>
                </div>
                <div class="online-iptbox">
                    <?= Html::input('submit', '', '立即获取报价', ['id' => 'online-btn']) ?>
                </div>
            <?= Html::endForm() ?>

                <div class="swiper-container" style="text-align: center;height: .3rem;">
                    <div class="swiper-wrapper">
                        <?php foreach (Inquiry::CallPriceUserList() as $record) { ?>
                            <div class="swiper-slide" style="font-size: .24rem;"><?= $record ?></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="online-iptbox" style="height: .6rem;margin-bottom: 0;">
                    <label for="">* 为了您的权益，您的隐私将被严格保密</label>
                </div>
        </div>

        <!-- 弹出框 -->
        <div id="fllow-wrap-tpl" style="display: none;">
            <div class="follow-wrap">
                <p class="p1"> <i class="iconfont jia-yes_b"></i> 提交成功！</p>
                <p class="p3">稍后客服将来电，免费为您提供作业方案，更多高空作业服务、用车用人服务，请继续关注我们！</p>
            </div>
        </div>
    </div>
</div>
