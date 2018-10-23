<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model app\models\site\Help */

$this->title = '添加帮助信息';
?>
<div class="help-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>