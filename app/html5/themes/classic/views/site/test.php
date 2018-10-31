<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
手机端测试页
<br />
<?= Html::a('返回首页', Url::to(['site/home']))?>

<br />
语言切换菜单：
<?php 







echo '<br /><br /><br /><br /><br /><br /><br /><br />';

//如果手机端就提醒
echo '设备匹配：';
if(in_array(Yii::getAlias('@device'), ['desktop'])) {
    echo '您当前的设备是手机端';
    echo Html::a('切换到手机端', '');//多app跳转
} else {
    echo '设备匹配正常';
}
?>