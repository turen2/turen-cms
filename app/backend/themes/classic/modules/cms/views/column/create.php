<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model backend\models\cms\Column */

$this->title = '添加栏目';
?>
<div class="column-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>