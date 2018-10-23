<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\cms\Column */

$this->title = '添加栏目';
?>
<div class="column-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>