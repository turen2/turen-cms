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
?>

<div class="public-header public-fixed">
    <a class="back" href="<?= $url ?>"><img src="<?= $webUrl ?>images/yaqiao/back.png"></a>
    <p><?= empty($this->topTitle)?$title:$this->topTitle ?></p>
    <span class="nav"><img src="<?= $webUrl ?>images/yaqiao/nav-bar.png"></span>
</div>

<?= $this->render('_nav') ?>
