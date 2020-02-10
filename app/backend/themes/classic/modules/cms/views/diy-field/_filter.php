<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\cms\Column;

$id2NameList = Column::ColumnConvert('id2name');

$addRoutes = [
    Html::getInputName($model, 'keyword') => $model->keyword,
    Html::getInputName($model, 'status') => $model->status
];

$buildFilter = '';
foreach ($id2NameList as $id => $name) {
    //按照新的关系，重新排序
    if($id != Column::COLUMN_TYPE_CATE)
        $buildFilter .= '<a href="'.Url::to(ArrayHelper::merge(['index', Html::getInputName($model, 'fd_column_type') => $id], $addRoutes)).'">'.$name.'</a>';
}

if(!empty($buildFilter)) {
    $title = isset($id2NameList[$model->fd_column_type])?$id2NameList[$model->fd_column_type]:'全部类型';
    echo '<span class="alltype"><a href="'.Url::to(ArrayHelper::merge(['index'], $addRoutes)).'" title="点击查看全部类型" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}