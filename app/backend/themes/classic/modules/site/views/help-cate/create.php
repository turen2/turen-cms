<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $this yii\web\View */
/* @var $model backend\models\site\HelpCate */

$this->title = '添加帮助分类';
?>
<div class="help-cate-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>