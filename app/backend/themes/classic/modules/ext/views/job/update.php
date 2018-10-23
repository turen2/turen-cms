<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
?>
<?php
$this->title = '编辑招聘信息';
?>
<div class="job-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>