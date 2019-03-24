<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\PinAsset;
use app\assets\YetiiAsset;

$this->title = '自助价格计算器';

PinAsset::register($this);
YetiiAsset::register($this);
$js = <<<EOF
$(".float-left-side, .float-right-side").pin({
      padding: {top: 96}
});
var tabbertabs = new Yetii({
    'id': 'calculator-tabs',
    'tabclass': 'tab',
    'active': 1,
    'activeclass': 'on',
});
EOF;
$this->registerJs($js);
?>

<div class="container calculator">
    <div class="calculator-top">
        <h6>自动价格计算器</h6>
        <p>今天已经有24位业主获取搬家报价</p>
    </div>
    <div class="calculator-content clearfix" id="calculator-tabs">
        <div class="calculator-left">
            <ul class="float-left-side br10" id="calculator-tabs-nav">
                <li><a href="#tabjumin">居民搬家</a></li>
                <li><a href="#tabshangpu">商铺搬迁</a></li>
                <li><a href="#tabjuidian">酒店搬迁</a></li>
                <li><a href="#tabbangong">办公室搬迁</a></li>
                <li><a href="#tabchangfang">厂房搬迁</a></li>
                <li><a href="#tabschool">学校搬迁</a></li>
                <li><a href="#tabchangku">仓库搬迁</a></li>
                <li><a href="#tabchangtu">长途搬家</a></li>
                <li><a href="#tabserver">服务器搬迁</a></li>
                <li><a href="#tabqizheng">起重设备吊装</a></li>
            </ul>
        </div>
        <div class="calculator-middle-right clearfix">
            <div class="tab" id="tabjumin" style="display: none;">
                <?= $this->render('_tabjumin') ?>
            </div>
            <div class="tab" id="tabshangpu" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabjuidian" style="display: none;">
                tabjuidian
            </div>
            <div class="tab" id="tabbangong" style="display: none;">
                tabbangong
            </div>
            <div class="tab" id="tabchangfang" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabschool" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabchangku" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabchangtu" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabserver" style="display: none;">
                tabshangpu
            </div>
            <div class="tab" id="tabqizheng" style="display: none;">
                tabshangpu
            </div>
        </div>
    </div>
</div>

