<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model backend\models\cms\Article */

$this->title = '添加文章信息';
?>
<div class="article-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>