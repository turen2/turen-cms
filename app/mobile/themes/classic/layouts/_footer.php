<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use common\models\cms\Block;
use common\models\ext\Nav;
use yii\helpers\Url;

$js = <<<EOF
window.onscroll = function () {
    if ($(window).scrollTop() >= 800) {
        $('.goto-top').fadeIn(1000)
    } else {
        $('.goto-top').fadeOut(1000)
    }
}
$(function () {
    $('.goto-top').click(function () {
        $('body,html').animate({scrollTop: 0}, 1000);
        return false;
    })
})
EOF;
$this->registerJs($js);

$bottomMenuModels = Nav::find()->active()->andWhere(['parentid' => Yii::$app->params['config_face_mobile_cn_bottom_nav_id']])->orderBy(['orderid' => SORT_DESC])->all();
$aboutModel = Block::find()->andWhere(['id' => Yii::$app->params['config_face_mobile_cn_bottom_block_id']])->one();

$webUrl = Yii::getAlias('@web/');
?>

<div class="msg">
    <span><img src="<?= $webUrl ?>images/yaqiao/msg.png"></span>
    <p><?= empty($aboutModel)?'手机网站底部关于我们简述':$aboutModel->content ?></p>
</div>
<div class="footer">
    <ul>
        <?php foreach ($bottomMenuModels as $key => $bottomMenuModel) { ?>
        <li><a href="<?= $bottomMenuModel->linkurl ?>"><?= $bottomMenuModel->menuname ?></a></li>
            <?php if(count($bottomMenuModels) != $key + 1) { ?>
                <li><span></span></li>
            <?php } ?>
        <?php } ?>
    </ul>
    <div class="footer-btn">
        <a href="tel:<?= Yii::$app->params['config_hotline'] ?>"><img src="<?= $webUrl ?>images/yaqiao/footerbtn.png">租赁咨询热线：<em><?= Yii::$app->params['config_hotline'] ?></em></a>
    </div>
    <div class="copyright">
        <p><?= Yii::$app->params['config_copyright'] ?></p>
        <p>Copyright © 2016-<?= date('Y') ?> <?= Yii::$app->params['config_icp_code'] ?></p>
    </div>
</div>
<div class="goto-top" style="display:none">
    <div class="fix-nav-wrap">
        <img class="i-totop" src="<?= $webUrl ?>images/yaqiao/goto2.png">
    </div>
</div>

<div class="footer-block clear-footer">
    <div class="footer-block-v2">
        <a class="block-button icon-home" href="<?= Url::to(['/home/default']) ?>"><i class="iconfont jia-home"></i> 首页</a>
        <a class="block-button icon-user" href="javascript:;" onclick="javascript: $('#newBridge #nb_icon_wrap').click();"><i class="iconfont jia-kefu"></i> 咨询</a>
        <a class="block-button flex-button consult-btn" href="tel:<?= Yii::$app->params['config_site_telephone'] ?>"><i class="iconfont jia-tel" style="font-size: .36rem;"></i> 马上拨打</a>
    </div>
</div>