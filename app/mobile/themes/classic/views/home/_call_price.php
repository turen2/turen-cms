<?php

use app\assets\LayerAsset;
use app\assets\Swiper3Asset;
use app\assets\ValidationAsset;
use common\models\account\Inquiry;
use yii\helpers\Html;

Swiper3Asset::register($this);
LayerAsset::register($this);
ValidationAsset::register($this);
$js = <<<EOF2
//下单跳动效果
var callOrderSwiper = new Swiper('.freedesign-form .swiper-container', {
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

<div id="freeform"></div>

<div class="freedesign-form">
    <div class="freedesign-title">
        <img src="<?= $webUrl ?>images/yaqiao/free-design.png">
    </div>

    <?= $form = Html::beginForm(['/online/price'], 'POST', ['class' => 'online-form']) ?>
        <div class="freedesign-box">
            <?= Html::textInput('name', '', ['placeholder' => '请输入您的称呼']) ?>
        </div>
        <div class="freedesign-box">
            <?= Html::textInput('phone', '', ['placeholder' => '输入您的号码']) ?>
        </div>
        <div class="freedesign-box freedesign-color" style="margin-bottom: .1rem;">
            <?= Html::input('submit', '', '立即获取报价', ['id' => 'online-btn']) ?>
        </div>
    <?= Html::endForm() ?>

    <div class="swiper-container" style="text-align: center;height: .38rem;line-height: .38rem;">
        <div class="swiper-wrapper">
            <?php foreach (Inquiry::CallPriceUserList() as $record) { ?>
                <div class="swiper-slide" style="font-size: .24rem;"><?= $record ?></div>
            <?php } ?>
        </div>
    </div>

    <label for="">* 为了您的权益，您的隐私将被严格保密</label>

    <!-- 弹出框 -->
    <div id="fllow-wrap-tpl" style="display: none;">
        <div class="follow-wrap">
            <p class="p1"> <i class="iconfont jia-yes_b"></i> 提交成功！</p>
            <p class="p3">稍后客服将来电，免费为您提供作业方案，更多高空作业服务、用车用人服务，请继续关注我们！</p>
        </div>
    </div>
</div>