<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\assets\YetiiAsset;
use app\assets\DatetimePickerAsset;

DatetimePickerAsset::register($this);
YetiiAsset::register($this);
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
var tabber1 = new Yetii({
    'id': 'calculator-subtabs',
    'tabclass': 'tab-nested',
    'active': 1,
    'activeclass': 'on',
});
EOF;
$this->registerJs($js);
?>

<div class="calculator-middle br10">
    <h3 class="tit">居民搬家<span>适用于家庭、居民、白领、个人等小规模搬运</span></h3>
    <div class="calculator-common">
        <?= $this->render('_common') ?>
    </div>

    <div class="calculator-subtabs" id="calculator-subtabs">
        <ul class="clearfix" id="calculator-subtabs-nav">
            <li><a href="#tab-nested1">笨重物品</a></li>
            <li><a href="#tab-nested2">家用电器</a></li>
            <li><a href="#tab-nested3">家具拆装</a></li>
            <li><a href="#tab-nested4">打包材料</a></li>
        </ul>
        <div class="tab-nested" id="tab-nested1" style="display: none;">
            <h2>笨重物品1</h2>
            <br /><br /><br /><br /><br /><br /><br /><br /><br />
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        </div>
        <div class="tab-nested" id="tab-nested2" style="display: none;">
            <h2>家用电器</h2>
            <br /><br /><br /><br /><br /><br /><br /><br /><br />
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        </div>
        <div class="tab-nested" id="tab-nested3" style="display: none;">
            <h2>家具拆装</h2>
            <br /><br /><br /><br /><br /><br /><br /><br /><br />
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        </div>
        <div class="tab-nested" id="tab-nested4" style="display: none;">
            <h2>打包材料</h2>
            <br /><br /><br /><br /><br /><br /><br /><br /><br />
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        </div>
    </div>

    <p>*声明: 亚桥租赁为您提供专业、透明、准确的搬运报价，该项服务绝不产生任何费用，您的隐私将被严格保密！</p>
</div>
<div class="calculator-right">
    <?= $this->render('_sidebox') ?>
</div>