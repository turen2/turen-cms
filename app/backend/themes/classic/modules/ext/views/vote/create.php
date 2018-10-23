<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
?>
<?php
$this->title = '添加投票信息';
?>
<div class="vote-create">
    <?= $this->render('_form', [
        'model' => $model,
        'optionModel' => $optionModel,
    ]) ?>
</div>