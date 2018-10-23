<?php

/* @var $this yii\web\View */
/* @var $model app\models\sys\Config */

$this->title = '站点设置';
?>

<div class="create-form">
    <?= $this->render('_create_form', [
        'configs' => $configs,
        'model' => $model,
    ]) ?>
</div>