<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Video */

$this->title = '编辑视频信息';
?>
<div class="video-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>