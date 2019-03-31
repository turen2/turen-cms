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

CONFIG.islogin = '';<?php // \Yii::$app->getUser()->isGuest?'false':'true' ?>;//登录状态

CONFIG.com = {
    'logoutUrl': '<?= Url::to(['/account/user/logout']) ?>',
    'consultUrl': '<?= Url::to(['/service/consult']) ?>',
};

CONFIG.cms = {
	
};

CONFIG.ext = {
		
};

CONFIG.shop = {
	'attrFormUrl': '<?= Url::to(['/shop/product/list']) ?>'
};
</script>