<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\ext\AdType;

//广告位下拉
$models = AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, AdType::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);
$adTypeArray = [];
foreach ($list as $id => $item) {
    //按照新的关系，重新排序
    $adTypeArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->typename);
}
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_login_signup_ad_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">登录/注册广告位</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $adTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>