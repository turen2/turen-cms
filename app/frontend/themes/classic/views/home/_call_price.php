<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\assets\LayerAsset;
use app\assets\Swiper2Asset;
use app\assets\ValidationAsset;
use common\helpers\ImageHelper;
use common\models\account\Inquiry;

Swiper2Asset::register($this);
LayerAsset::register($this);
ValidationAsset::register($this);

$js = <<<EOF
//下单跳动效果
var callOrderSwiper = new Swiper('.call-form .swiper-container', {
    mode: 'vertical',//纵向模式
    loop: true,//循环
    autoplay: 3500,//自动播放且间隔为3.5秒
    autoplayDisableOnInteraction: true,//用户操作后，autoplay将禁止
});
var validator = $('form.online-price').validate({
	rules: {
        service: {
            required: true,
        },
        name: {
            required: true,
        },
        phone: {
            required: true,
            isPhone: true,
        },
    },
	messages: {
        service: {
            required: '<i class="iconfont jia-close_b"></i>请选择业务'
        },
        name: {
            required: '<i class="iconfont jia-close_b"></i>称呼必填'
        },
        phone: {
            required: '<i class="iconfont jia-close_b"></i>手机号码必填',
            isPhone: '<i class="iconfont jia-close_b"></i>号码格式有误'
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
            ,area: ['416px', '286px'] //宽高
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
EOF;
$this->registerJs($js);
?>

<div class="call-form">
    <div class="home-pulish">
        <h3 class="title">轻松获取在线报价</h3>
        <?= $form = Html::beginForm(['home/call-price'], 'POST', ['class' => 'online-price']) ?>
        <div class="form-items">
            <span class="label">业务类型</span>
            <?= Html::dropDownList('service', null, ArrayHelper::merge([null => '选择业务类型'], ArrayHelper::merge(['其它' => '其它高空业务'], ArrayHelper::map($productList, 'title', 'title')))) ?>
        </div>
        <div class="form-items">
            <span class="label">您的称呼</span>
            <?= Html::textInput('name', '', ['placeholder' => '请输入您的称呼']) ?>
        </div>
        <div class="form-items">
            <span class="label">手机号码</span>
            <?= Html::textInput('phone', '', ['placeholder' => '请输入手机号码']) ?>
        </div>
        <?= Html::submitButton('立即免费回电', ['class' => 'primary-btn br5']) ?>
        <?= Html::endForm() ?>

        <!-- 弹出框 -->
        <div id="fllow-wrap-tpl" style="display: none;">
            <div class="follow-wrap">
                <p class="p1"> <i class="iconfont jia-yes_b"></i> 提交成功！</p>
                <p class="p3">稍后客服将来电，免费为您提供定制服务</p>
                <div class="fllow-img"><img src="<?= empty(Yii::$app->params['config_service_qr'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_service_qr'], true) ?>" /> </div>
                <p class="p2">您也可以微信扫一扫，交流更方便</p>
                <p class="p4">更多高空作业服务、用车用人服务，供您使用！</p>
            </div>
        </div>

        <!-- widget缓存 -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach (Inquiry::CallPriceUserList() as $record) { ?>
                <div class="swiper-slide"><?= $record ?></div>
                <?php } ?>
            </div>
        </div>
        <p class="text"><span class="red">*</span>声明：为了您的权益，您的隐私将被严格保密！</p>
    </div>
</div>