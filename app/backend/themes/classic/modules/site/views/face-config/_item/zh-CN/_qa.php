<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\cms\Column;
use common\helpers\BuildHelper;

//获取数据
$columnModels = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$columnModels = BuildHelper::reBuildModelKeys($columnModels, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($columnModels, Column::class, 'id', 'parentid');//获取父子关系
$columnList = BuildHelper::buildList($nexus);
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_faqs_column_id';
$value = isset($config[$name])?$config[$name]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($columnList as $id => $item) {
    if(Column::ColumnConvert('class2id', 'backend\models\cms\MasterModel_7') != $columnModels[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($columnModels[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">常见问答</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>