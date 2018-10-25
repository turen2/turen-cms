<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
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

CONFIG.sys = {
	'templateSelectUrl': '<?= Url::to(['/sys/template/template-select']) ?>'
};
</script>