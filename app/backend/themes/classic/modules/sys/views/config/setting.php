<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
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