<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\ImageHelper;
use common\models\com\FeedbackForm;
use app\assets\LayerAsset;
use app\assets\NotifyAsset;
use common\models\account\FeedbackType;

//问题类型
$feedbackTypeList = ArrayHelper::map(FeedbackType::find()->active()->current()
    ->where(['fkt_form_show' => FeedbackType::SHOW_YES])->orderBy(['orderid' => SORT_DESC])->asArray()->all(), 'fkt_id', 'fkt_form_name');
//初始化，考虑一下session或者cookie值，防止刷新丢失。
$feedbackModel = new FeedbackForm();
if(!Yii::$app->getUser()->getIsGuest()) {
    $userModel = Yii::$app->getUser()->getIdentity();
    $feedbackModel->contact = empty($userModel->phone)?$userModel->email:$userModel->phone;
    $feedbackModel->nickname = $userModel->username;
}

NotifyAsset::register($this);
LayerAsset::register($this);
$js = <<<EOF
$.notify.defaults({
    autoHideDelay: 2000,
    showDuration: 600,
    hideDuration: 200,
    globalPosition: 'top center'
});

//返回顶部
var backtop = $(".fixed-nav .back-top");
$(document).scroll(function() {
    $(this).scrollTop()>600?backtop.fadeIn(200):backtop.fadeOut(200)
});

//投诉建议
$('#complaint-btn').on('click', function() {
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        anim: -1,//无动画
        //shade: false,//无背景遮布
        area: '760px', //只取宽，高度自适应
        //area: ['760px', '460px'], //宽高
        move: false, //来禁止拖拽
        skin: 'feedback-pop',
        content: $('#feedback-wrap-tpl')//模板，注意：layer是自动克隆的，所以一定要传入对象。牛逼
    });
});

//单选效果
$('.feedback-wrap .radio-list input').eq(0).attr('checked', 'checked');//取第一个选中
$('.feedback-wrap .radio-list input:checked').parent().addClass('on');//没弹窗之前的初始化
$('body').on('click', '.radio-list label', function() {//弹出窗，DOM发生了变化，要从body扫描获取
    $(this).parent().find('label').removeClass('on').parent().find('label input:checked').parent().addClass('on');
    //console.log($(this).parent().find('label input:checked').val());
});

//placeholder效果
$('.feedback-wrap .form-group .form-control').each(function(i){
    if($(this).val() != '') {
        $(this).next('.placeholder').hide();
    }
});
$('body').on('focus', '.feedback-wrap .form-group .form-control', function() {
    $(this).next('.placeholder').hide();
}).on('blur', '.feedback-wrap .form-group .form-control', function() {
    if($(this).val() == '') {
        $(this).next('.placeholder').show();
    }
}).on('click', '.feedback-wrap .form-group .placeholder', function() {//点击到placeholder上了
    if($(this).prev().val() == '') {
        //$(this).hide();
        $(this).prev().focus();
    }
});

//解决弹出窗，验证码bug
//$('body').on('click', '#feedback-verifycode-image', function() {
//    alert('弹出了');
//});
//$('body #feedback-verifycode-image').yiiCaptcha({"refreshUrl":"/home/captcha.html?refresh=1","hashKey":"yiiCaptcha/home/captcha"});
EOF;
$this->registerJs($js);
?>

<div id="feedback-wrap-tpl" style="display: none;">
    <div class="feedback-wrap br5">
        <a href="javascript:layer.closeAll();" class="fk-close br4" title="反馈关闭"><i class="iconfont jia-error"></i></a>
        <p class="fk-title">问题反馈</p>
        <p class="fk-text">感谢您对我们工作的支持与帮助，提交成功后我们会尽快与您取得联系</p>
        <?= Html::beginForm(Url::to(['/home/feedback']), 'POST', ['onsubmit' => "return turen.com.feedbackCheck(this);"]) ?>
        <div class="form-group first">
            <?= Html::activeRadioList($feedbackModel, 'type', $feedbackTypeList, ['class' => 'radio-list clearfix']) ?>
        </div>
        <div class="form-group">
            <?= Html::activeTextarea($feedbackModel,  'content', ['class' => 'form-control textarea']) ?>
            <span class="placeholder" style="display: block;">请输入内容详情</span>
        </div>
        <div class="form-group list clearfix">
            <div class="col">
                <?= Html::activeTextInput($feedbackModel, 'nickname', ['class' => 'form-control text']) ?>
                <span class="placeholder" style="display: block;">请输入您的称呼</span>
            </div>
            <div class="col">
                <?= Html::activeTextInput($feedbackModel, 'contact', ['class' => 'form-control text']) ?>
                <span class="placeholder" style="display: block;">请输入您的联系方式</span>
            </div>
            <div class="col">
                <?= Html::activeTextInput($feedbackModel, 'verifyCode', ['class' => 'form-control text']) ?>
                <span class="placeholder" style="display: block;">请输入验证码</span>
                <?= Captcha::widget([
                    'model' => $feedbackModel,
                    'attribute' => 'verifyCode',
                    'captchaAction' => '/home/captcha',
                    'template' => '{image}',
                    'options' => ['class' => 'form-control', 'placeholder' => $feedbackModel->getAttributeLabel('verifyCode')],
                    'imageOptions' => ['title' => '点击刷新', 'alt' => '验证码', 'style' => 'cursor: pointer;'],
                ]) ?>
            </div>
            <div class="col" style="line-height: 34px;">点击图片刷新</div>
        </div>
        <div class="form-group last">
            <?= Html::submitButton('提交反馈', ['class' => 'primary-btn br5']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>

<div class="fixed-nav">
    <ul>
        <li class="contact-qq tbs-contact-qq" id="onlineService">
            <a target="_blank" href="javascript:;">
                <span class="s1"><i class="iconfont jia-kefu"></i><span class="point"></span></span><i>在线预约</i>
            </a>
        </li>
        <li class="sub-encode">
            <a href="javascript:;">
                <span class="s2"><i class="iconfont jia-qrcode"></i></span><i>手机浏览</i>
            </a>
            <ul class="encode">
                <li><span class="wap"><img src="<?= empty(Yii::$app->params['config_hedader_phone_qr'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_hedader_phone_qr'], true) ?>" /></span><b>手机浏览</b><p>在线下单立享9折</p></li>
            </ul>
        </li>
        <li class="">
            <a href="<?= Url::to(['/calculator/index']) ?>" class="alert-design right-offer">
                <span class="s4"><i class="iconfont jia-calculator"></i></span><i>自助计价</i>
            </a>
        </li>
        <li class="">
            <a href="javascript:;" id="complaint-btn">
                <span class="s3"><i class="iconfont jia-complain"></i></span><i>投诉建议</i>
            </a>
        </li>
        <li class="back-top" style="display: none;">
            <a href="javascript:turen.com.scrollTop(500);">
                <span class="s5"><i class="iconfont jia-return"></i></span><i>回到顶部</i>
            </a>
        </li>
    </ul>
</div>