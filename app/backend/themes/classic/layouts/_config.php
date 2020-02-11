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
    'logoutUrl': '<?= Url::to(['/site/admin/logout']) ?>',
    'pinyinUrl': '<?= Url::to(['/com/link/pinyin']) ?>'
};

CONFIG.cms = {
	'columnCheckBoxListUrl': '<?= Url::to(['/cms/diy-field/column-check-box-list']) ?>',
	'columnFlagListUrl': '<?= Url::to(['/cms/flag/column-flag-list']) ?>'
};

CONFIG.ext = {

};

CONFIG.shop = {
	'attrFormUrl': '<?= Url::to(['/shop/product/attr-form']) ?>'
};

CONFIG.tool = {

};

CONFIG.sys = {

};
</script>