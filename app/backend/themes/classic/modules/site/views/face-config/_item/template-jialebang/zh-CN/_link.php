<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\ext\LinkType;
use common\helpers\BuildHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//获取数据
$models = LinkType::find()->current()->orderBy(['orderid' => SORT_DESC])->all();

$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, LinkType::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);

$linkTypeArray = [];
foreach ($list as $id => $item) {
    //按照新的关系，重新排序
    $linkTypeArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->typename);
}
?>



<?php
//-----------------------------------------------
$name = 'config_face_banjia_cn_bottom_link_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">底部了解家乐邦链接组</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $linkTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>
