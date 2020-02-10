<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use frontend\widgets\cascade\CascadeWidget;
use frontend\assets\DatetimePickerAsset;

DatetimePickerAsset::register($this);
$js = <<<EOF
//日期选择
$.datetimepicker.setLocale('ch');
$('input[name="cl-time"]').datetimepicker({
    'elem':'input[name="cl-time"]',
    'format':'Y年m月d日 H:i',
    'allowTimes':[
        '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
    ]
});
//初始化label
$('.cl-radio input:checked').each(function() {
    $(this).parent().addClass('on');
});
$('.cl-radio input').on('click', function() {
    $('.cl-radio input').parent().removeClass('on');
    $(this).parent().addClass('on');
    //console.log($(this).val());
});
EOF;
$this->registerJs($js);
?>

<div class="form-items">
    <div class="items clearfix">
        <label for="" class="fl">起点 : <span>*</span></label>
        <div class="item-box fl">
            <?= CascadeWidget::widget([
                'province' => '广东省',
                'cities' => [
                    '深圳市' => '深圳市',
                    '广州市' => '广州市',
                    '中山市' => '中山市',
                    '东莞市' => '东莞市',
                    '惠州市' => '惠州市',
                    '佛山市' => '佛山市'
                ],
                'formId' => 'cl-start',
            ]); ?>
            <?= Html::dropDownList('cl-start-stair', '有电梯', [
                '有电梯' => '有电梯',
                '无电梯1~3层' => '无电梯1~3层',
                '无电梯4~6层' => '无电梯4~6层',
                '无电梯7~9层' => '无电梯7~0层',
                '无电梯10~12层' => '无电梯10~12层',
            ]) ?>
        </div>
    </div>
    <span class="cue"></span>
</div>
<div class="form-items">
    <div class="items clearfix">
        <label for="" class="fl">终点 : <span>*</span></label>
        <div class="item-box fl">
            <?= CascadeWidget::widget([
                'province' => '广东省',
                'cities' => [
                    '深圳市' => '深圳市',
                    '广州市' => '广州市',
                    '中山市' => '中山市',
                    '东莞市' => '东莞市',
                    '惠州市' => '惠州市',
                    '佛山市' => '佛山市'
                ],
                'formId' => 'cl-end',
            ]); ?>
            <?= Html::dropDownList('cl-end-stair', '有电梯', [
                '有电梯' => '有电梯',
                '无电梯1~3层' => '无电梯1~3层',
                '无电梯4~6层' => '无电梯4~6层',
                '无电梯7~9层' => '无电梯7~0层',
                '无电梯10~12层' => '无电梯10~12层',
            ]) ?>
        </div>
    </div>
    <span class="cue"></span>
</div>
<div class="form-items">
    <div class="items clearfix"><label for="" class="fl">车辆类型 : <span>*</span></label>
        <div class="item-box fl">
            <?= Html::radioList('cl-truck', '小面包车', [
                '小面包车' => '小面包车',
                '中面包车' => '中面包车',
                '小货车' => '小货车',
                '中货车' => '中货车',
                '大货车' => '大货车',
            ], ['class' => 'cl-radio'], ['itemOptions' => ['labelOptions' => ['class' => 'br5']]]) ?>
        </div>
    </div>
    <span class="cue"></span>
</div>
<div class="form-items">
    <div class="items clearfix"><label for="" class="fl">联系方式 : <span>*</span></label>
        <div class="item-box fl">
            <?= Html::textInput('cl-nickname', '', ['placeholder' => '您的称呼', 'style' => 'width: 90px;']) ?>
            <?= Html::dropDownList('cl-contact-type', '电话', [
                '电话' => '电话',
                '邮件' => '邮件',
                '微信' => '微信',
                'QQ' => 'QQ',
            ]) ?>
            <?= Html::textInput('cl-contact', '', ['placeholder' => '联系方式', 'style' => 'width: 150px;']) ?>
        </div>
    </div>
    <span class="cue"></span>
</div>
<div class="form-items">
    <div class="items clearfix"><label for="" class="fl">预约时间 : <span>*</span></label>
        <div class="item-box fl">
            <?= Html::textInput('cl-time', date('Y年m月d日 H:i'), ['placeholder' => '预约时间', 'class' => 'date-time', 'style' => 'width: 200px;']) ?>
        </div>
    </div>
    <span class="cue"></span>
</div>