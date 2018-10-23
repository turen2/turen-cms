<?php 
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
?>

<?php
$this->title = '编辑广告位';
?>
<div class="ad-type-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>