<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
?>
<div class="error-bg">
	<h3><?php // $name ?></h3>
	<p><?= $message ?></p>
	
	<a class="refresh-btn" href="<?= Url::current() ?>"><i class="fa fa-refresh"></i> 刷新页面</a>
	<a class="return-btn" href="<?= Url::to(['/site/home/default']) ?>"><i class="fa fa-undo"></i> 返回首页</a>
</div>