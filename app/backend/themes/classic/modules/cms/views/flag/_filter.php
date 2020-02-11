<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\cms\Column;
use backend\models\cms\DiyModel;

$columnModel = Column::findOne($model->columnid);

$types = [];
foreach (DiyModel::find()->select('dm_id')->asArray()->all() as $dm) {
    $types[] = $dm['dm_id'];
}
$types = ArrayHelper::merge(array_values($types), [Column::COLUMN_TYPE_ARTICLE, Column::COLUMN_TYPE_FILE, Column::COLUMN_TYPE_PHOTO, Column::COLUMN_TYPE_PRODUCT, Column::COLUMN_TYPE_VIDEO]);
$buildFilter = BuildHelper::buildFilter(Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, $types, 'FlagSearch', 'columnid');
if(!empty($buildFilter)) {
    $title = is_null($columnModel)?'全部栏目':$columnModel->cname;
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部栏目" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}