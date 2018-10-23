<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
?>

<script>
//全局js参数
var CONFIG = {};

CONFIG.islogin = <?= \Yii::$app->getUser()->isGuest?'false':'true' ?>;//登录状态

CONFIG.com = {
    'logoutUrl': '<?= Url::to(['/site/admin/logout']) ?>'
};

CONFIG.cms = {
	
};

CONFIG.ext = {
		
};

CONFIG.shop = {
	'attrFormUrl': '<?= Url::to(['/shop/product/attr-form']) ?>'
};

CONFIG.tool = {
		
};
</script>