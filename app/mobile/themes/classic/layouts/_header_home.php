<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$js = <<<EOF

EOF;
$this->registerJs($js);

$webUrl = Yii::getAlias('@web/');

use yii\helpers\Url; ?>

<div class="header public-fixed">
    <div class="logo">
        <img src="<?= $webUrl ?>images/yaqiao/logo.png" style="width: .7rem;" />
    </div>
    <div class="home-header">
        <span class="home-title"><img src="<?= $webUrl ?>images/yaqiao/logo2.png" alt="亚桥机械租赁有限公司" title="亚桥机械租赁有限公司" style="width: 2rem;" /></span>
    </div>
    <div class="search-nav">
        <a class="search" href="<?= Url::to(['/search/list']) ?>"><img src="<?= $webUrl ?>images/yaqiao/search.png" /></a>
        <span class="nav"><img src="<?= $webUrl ?>images/yaqiao/nav-bar.png" /></span>
    </div>
</div>

<?= $this->render('_nav') ?>
