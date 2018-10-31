<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
?>

<ul class="lang-selector">
<?php 
foreach ($items as $langKey => $item) {
    if($langKey == Yii::$app->params['config_init_default_lang_key']) {
        echo '<li'.(($langKey == $selection)?' class="on"':'').'>'.Html::a($item['name'], $baseUrl.'/index.html').'</li>';
    } else {
        echo '<li'.(($langKey == $selection)?' class="on"':'').'>'.Html::a($item['name'], $baseUrl.'/'.$langKey.'/index.html').'</li>';
    }
}
?>
</ul>