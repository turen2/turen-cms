<?php 
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
?>
<?php
$this->title = '编辑投票信息';
?>
<div class="vote-update">
    <?= $this->render('_form', [
        'model' => $model,
        'optionModel' => $optionModel,
        'optionModels' => $optionModels,
    ]) ?>
</div>