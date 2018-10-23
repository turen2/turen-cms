<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '站点设置';
?>

<div class="config-form">
    <?= $this->render('_setting_form', [
        'configs' => $configs,
        'model' => $model,
    ]) ?>
</div>