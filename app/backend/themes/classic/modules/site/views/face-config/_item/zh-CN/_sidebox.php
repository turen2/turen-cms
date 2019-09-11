<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\models\cms\Flag;
use common\helpers\BuildHelper;
use common\models\cms\Block;
use common\models\cms\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$blockArray =  ArrayHelper::map(Block::find()->current()->orderBy(['updated_at' => SORT_DESC])->asArray()->all(), 'id', 'title');

//获取数据
$models = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all();
$models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
$nexus = BuildHelper::getModelNexus($models, Column::class, 'id', 'parentid');//获取父子关系
$list = BuildHelper::buildList($nexus);
?>

<?php
//-----------------------------------------------
$name = 'config_face_cn_sidebox_contact_us_block_id';
$value = isset($config[$name])?$config[$name]:null;
?>
<tr>
    <td class="first-column">百科列表联系我们</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $blockArray), ['id' => $name]) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$name = 'config_face_cn_sidebox_baike_column_id';
$value = isset($config[$name])?$config[$name]:null;
$flagName = 'config_face_cn_sidebox_baike_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
$columnArray = [];
$selectOptions = ['id' => $name, 'encode' => false, 'options' => []];
$options = [];
foreach ($list as $id => $item) {
    if(Column::COLUMN_TYPE_ARTICLE != $models[$id]->type) {
        $options[$id] = ['disabled' => true];
    }
    //按照新的关系，重新排序
    $columnArray[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->cname);
}
$selectOptions['options'] = $options;
?>
<tr>
    <td class="first-column">百科推荐所属栏目</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($name, $value, ArrayHelper::merge([null => '请选择一个配置'], $columnArray), $selectOptions) ?>
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$name?>']<br />
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_sidebox_current_article_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">当前文章栏目标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_ARTICLE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_sidebox_current_photo_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">当前图片栏目标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_PHOTO, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_sidebox_current_file_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">当前文件栏目标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_FILE, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>

<?php
//-----------------------------------------------
$flagName = 'config_face_cn_sidebox_current_video_column_flag';
$flagValue = isset($config[$flagName])?$config[$flagName]:null;
?>
<tr>
    <td class="first-column">当前视频栏目标记</td>
    <td class="second-column" width="33%">
        <?= Html::dropDownList($flagName, $flagValue, ArrayHelper::merge([null => '所有标记'], Flag::FlagList(Column::COLUMN_TYPE_VIDEO, true))) ?>
    </td>
    <td style="border-bottom: 1px dashed #efefef;">
        Yii::$app->params['<?=$flagName?>']
    </td>
</tr>