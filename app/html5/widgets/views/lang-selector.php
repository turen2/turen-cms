<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
?>

<span class="lang-selector">
<?php 
foreach ($items as $langKey => $item) {
    if($langKey == Yii::$app->params['config_init_default_lang_key']) {
        echo Html::a($item['name'], $baseUrl.'/index.html');
    } else {
        echo Html::a($item['name'], $baseUrl.'/'.$langKey.'/index.html');
    }
    echo ' ';
}
?>
</span>