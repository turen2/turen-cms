<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Video */

$this->title = '添加视频信息';
?>
<div class="video-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>