<?php 
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
?>
<?php
$this->title = '添加招聘信息';
?>
<div class="job-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>