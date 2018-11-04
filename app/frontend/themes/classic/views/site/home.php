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

$this->title = '首页 - '.Yii::$app->params['config_site_name'];
?>
电脑端首页
<br />
<?= Html::a('测试页面', Url::to(['site/test']))?>

<br />
语言切换菜单：
<?php 
echo LangSelector::widget([]);





echo '<br /><br /><br /><br /><br /><br /><br /><br />';

//如果手机端就提醒
echo '设备匹配：';
if(in_array(Yii::getAlias('@device'), ['mobile', 'tablet'])) {
    echo '您当前的设备是手机或平板，是否切换到手机或平板端';
    echo Html::a('切换到手机', '');//多app跳转
} else {
    echo '设备匹配正常';
}
?>