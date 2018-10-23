<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
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