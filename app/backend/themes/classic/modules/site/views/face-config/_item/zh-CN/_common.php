<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\ext\Nav;
use backend\models\cms\Block;
use backend\models\ext\LinkType;
use backend\models\ext\AdType;

$navArray = ArrayHelper::map(Nav::find()->current()->where(['parentid' => Nav::TOP_ID])->orderBy(['orderid' => SORT_DESC])->asArray()->all(), 'id', 'menuname');
$blockArray =  ArrayHelper::map(Block::find()->current()->orderBy(['updated_at' => SORT_DESC])->asArray()->all(), 'id', 'title');

//友情链接下拉
$models = LinkType::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, LinkType::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);
$linkTypeArray = [];
foreach ($list as $id => $item) {
    //按照新的关系，重新排序
    $linkTypeArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->typename);
}

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
$name = 'config_face_cn_main_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">主菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_bottom_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">底部菜单</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_about_us_nav_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">关于我们导航</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $navArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_left_top_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">系统左上角公告</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_left_bottom_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">系统左下角关于我们</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_bottom_link_type_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">底部了解我们链接组</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $linkTypeArray), ['id' => $name, 'encode' => false]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_sidebox_contact_us_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">全局侧边栏 - 联系我们</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>