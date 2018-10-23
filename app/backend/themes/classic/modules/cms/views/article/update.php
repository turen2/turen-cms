<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Article */

$this->title = '编辑文章信息';
?>
<div class="article-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>