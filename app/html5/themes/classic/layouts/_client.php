<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use app\widgets\LangSelector;

//客户端切换
if(in_array(Yii::getAlias('@device'), ['desktop'])) {
    echo '<div class="tui-title center">';
    echo Html::a(Yii::t('h5', '切换到电脑端'), '');
    echo '</div>';
}
?>

<div class="tui-title center"><?= Yii::t('h5', '语言').Yii::t('h5', '：')?><?= LangSelector::widget([]) ?></div>

<div class="tui-title center">Copyright © 2004-2018 XXX xxx.com 版权所有</div>