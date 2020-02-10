<?php

use mobile\assets\LayerAsset;
use mobile\assets\Swiper3Asset;
use common\helpers\ImageHelper;
use common\models\ext\Nav;

$webUrl = Yii::getAlias('@web/');

LayerAsset::register($this);
Swiper3Asset::register($this);
$css = <<<EOF
.global-menu.layui-layer {
    border-bottom-left-radius: .2rem;
    border-bottom-right-radius: .2rem;
    z-index: 99999999 !important;
    overflow: hidden;
}
EOF;
$this->registerCss($css);

$img = $webUrl.'images/yaqiao/menu-tips.png';
$js = <<<EOF2
$(function () {
    //index页
    var index = 0;
    $('.nav').click(function () {
        layer.open({
            type: 1,
            area: ['100%', 'auto'],
            title: false,
            /*title:[' ','background-color:#fff;border:none;'],*/
            closeBtn: 0,
            shade: 0.8,
            shadeClose: true,
            scrollbar: false,
            content: $('.mainav'),
            offset: 't',
            id: 'global-menu'
        });
        
        // 特殊处理
        $('body #global-menu').parent().addClass('global-menu');
        
        $('.pub-hide .lookfor-subnav').css('display', 'none').removeClass('animated fadeInDown');
        $('.blackmask').css('display', 'none')
    });
    
    $('#nav_1').append('<img class="menu-hot" src="{$img}">');
});
EOF2;
$this->registerJs($js);

$mainNavModels = Nav::find()->active()->andWhere(['parentid' => Yii::$app->params['config_face_mobile_cn_main_nav_id']])->orderBy(['orderid' => SORT_DESC])->all();
?>
<div class="mainav">
    <ul>
        <?php
        foreach ($mainNavModels as $key => $mainNavModel) {
            $pic = empty($mainNavModel->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($mainNavModel->picurl, true);
        ?>
        <li>
            <a href="<?= $mainNavModel->linkurl ?>">
                <div class="mainav-box">
                    <span id="nav_<?= $key ?>">
                        <img src="<?= $pic ?>">
                    </span>
                    <p><?= $mainNavModel->menuname ?></p>
                </div>
            </a>
        </li>
        <?php } ?>
    </ul>
    <h5>
        <a href="/">
            <img src="<?= $webUrl ?>images/yaqiao/home.png">
            返回首页
        </a>
    </h5>
    <div class="menu_close" onclick="javascript:layer.closeAll();">
        <img src="<?= $webUrl ?>images/yaqiao/menu_close.png">
    </div>
</div>
