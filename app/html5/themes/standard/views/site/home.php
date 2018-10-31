<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use app\widgets\LangSelector;
?>
手机端首页
<br />
<?= Html::a('测试页面', Url::to(['site/test']))?>

<br />
语言切换菜单：
<?php 
echo LangSelector::widget([]);





echo '<br /><br /><br /><br /><br /><br /><br /><br />';

//如果电脑端就提醒
echo '设备匹配：';
if(in_array(Yii::getAlias('@device'), ['desktop'])) {
    echo '您当前的设备是电脑端';
    echo Html::a('切换到电脑端', '');//多app跳转
} else {
    echo '设备匹配正常';
}
?>