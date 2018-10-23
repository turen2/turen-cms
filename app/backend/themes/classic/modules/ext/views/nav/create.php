<?php 
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
?>
<?php
$this->title = '添加导航菜单';
?>

<div class="nav-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>