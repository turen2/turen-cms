<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>

这是手机版页面

<?php 
echo '<br />';
echo '<br />';

//如果电脑端就提醒
if(Yii::getAlias('@device') == 'desktop') {
    echo '您当前的设备是电脑，是否切换到电脑端';
    echo Html::a('切换到电脑', Url::to(['/']));
} else {
    echo '设备匹配正常';
}
?>