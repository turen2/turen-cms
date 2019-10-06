<?php
/**
 * Created by PhpStorm.
 * User: jorry
 * Date: 2019/3/31
 * Time: 22:58
 */

use app\assets\LayerAsset;
use app\widgets\cascade\CascadeWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

JqueryAsset::register($this);
LayerAsset::register($this);
$js = <<<EOF
    //摇摆效果
    function yaoyiyao(obj)
    {
        obj.css({'position':'relative'});
        for(var i=1; 4>=i; i++){
            obj.animate({left:-(20-5*i)}, 50);
            obj.animate({left:2*(20-5*i)}, 50);
        }
    }
    
    $('#free-jia-btn').on('click', function() {
        //各种验证
        var hasError = false;
        var orignColor = '1px solid #ddd';
        $('#call-start select, #call-end select, .call-time input, .call-truck select').each(function(i) {
            if($(this).val() == '') {
                hasError = true;
                $(this).css({'border': '1px solid red'});
                yaoyiyao($(this));
                $(this).unbind('focus');
                $(this).on('focus', function() {
                    $(this).css({'border': orignColor});
                });
            }
        });
        //收集数据
        
        
        //手机验证码（附加数字验证码）
        /**
        $('form[data-ajax-submit]').on('submit', function(event) {
        var form = $(this);
        if (event.eventPhase === 2) { // This phase is when the validation is passed
            $.ajax({ // actually the ajax request
                url: form.attr('action'),
                data: form.serialize(),
                type: form.attr('method')
            }); 
        }
        event.preventDefault(); // Prevents default submit behaviour
    });
    */
        
        //test
        $.ajax({
            url: 'http://turen.com/site/phone-verify-code.html',
            type: 'GET',
            dataType: 'html',
            context: $(this),
            cache: false,
            data: {},
            success: function(res) {
                $('.service-content').html(res);
            }
        });
        
        
        //提交数据
        /*
        if(!hasError) {
            $.ajax({
                url: CONFIG.com.consultUrl,
                type: 'POST',
                dataType: 'json',
                context: $(this),
                cache: false,
                data: {},
                success: function(res) {
                    if (res['state']) {
                        //alert(res.result);
                    } else {
                        //alert(res.result);
                    }
                }
            });
        }
        */
    });
EOF;
$this->registerJs($js);
?>
<div id="sidebox-jijia" class="tab-sidebox free-jijia card">
    <div class="tab-sidebox-title">
        <h3>免费咨询</h3>
    </div>
    <div class="tab-sidebox-content">
        <?= Html::hiddenInput('serviceName', $slug); ?>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-coordinates"></i> 起点：</h6>
            <p id="call-start">
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
                'formId' => 'call-start',
            ]); ?>
            </p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-coordinates"></i> 终点：</h6>
            <p id="call-end">
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
                'formId' => 'call-end',
            ]); ?>
            </p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-people"></i> 搬运工人：</h6>
            <?= Html::radioList('userNumber', '2人', ['1人' => '1人', '2人' => '2人', '3人' => '3人', '4人' => '4人', '更多' => '更多'], ['tag' => 'p', 'class' => 'call-number']) ?>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-calendar1"></i> 预约时间：</h6>
            <p class="call-time">
                <?= Html::textInput('callTime', date('Y年m月d日 H:i'), ['placeholder' => '选择日期']) ?>
            </p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-order_receive"></i> 车型类型：</h6>
            <p class="call-truck">
                <?= Html::dropDownList('callTruck', null, [
                        null => '请选择车型',
                        '小货车' => '小货车（0.8m x 3m x 2.5m）',
                ]) ?>
                <br />
                <a href="<?= Url::to(['page/info', 'slug' => 'chexing-shibei']) ?>" target="_blank"><i class="fa fa-info-circle"></i> 查看车型</a>
            </p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-task"></i> 要求<span style="font-size: 12px;font-weight: normal;">[可选]</span>：</h6>
            <p class="call-order">
                <?= Html::textarea('callOrder', '', ['class' => '', 'placeholder' => '请输入您的特殊要求']) ?>
            </p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-hongbao"></i> 费用：</h6>
            <p class="call-price">线上下单统一9折起</p>
        </div>
        <a id="free-jia-btn" class="primary-btn br5" href="javascript:;">立即咨询</a>
    </div>
</div>