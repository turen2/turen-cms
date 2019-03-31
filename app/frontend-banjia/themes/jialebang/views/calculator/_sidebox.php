<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\web\JqueryAsset;

JqueryAsset::register($this);
$js = <<<EOF
$('#excute-price').on('click', function() {
    alert('正在估算价格...');
});
EOF;
$this->registerJs($js);
?>

<div class="tab-sidebox float-right-side free-jijia br10">
    <div class="tab-sidebox-title">
        <h3>费用估算</h3>
    </div>
    <div class="tab-sidebox-content">
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-coordinates"></i> 起点：</h6>
            <p class="calculator-start br5">待选择</p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-coordinates"></i> 终点：</h6>
            <p class="calculator-start br5">待选择</p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-people"></i> 需要人数：</h6>
            <p class="calculator-start br5">0 个</p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-calendar1"></i> 预约时间：</h6>
            <p class="calculator-time br5">待选择</p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-order_receive"></i> 车型类型：</h6>
            <p class="calculator-truck br5">待选择</p>
        </div>
        <div class="row">
            <h6 class="form-label"><i class="iconfont jia-task"></i> 要求：</h6>
            <p class="calculator-order br5">待选择</p>
        </div>
        <div class="row hide">
            <h6 class="form-label"><i class="iconfont jia-hongbao"></i> 预估费用：</h6>
            <p class="calculator-price br5">计算中</p>
        </div>
        <a href="javascript:;" id="excute-price" class="primary-btn br5">立即估算</a>
    </div>
</div>