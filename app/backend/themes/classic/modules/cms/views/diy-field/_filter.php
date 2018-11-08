<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\models\cms\Column;
use yii\helpers\Url;

$id2NameList = Column::ColumnConvert('id2name');

$buildFilter = '';
foreach ($id2NameList as $id => $name) {
    //按照新的关系，重新排序
    $buildFilter .= '<a href="'.Url::to(['index', 'DiyFieldSearch[fd_column_type]' => $id]).'">'.$name.'</a>';
}

if(!empty($buildFilter)) {
    $title = isset($id2NameList[$model->fd_column_type])?$id2NameList[$model->fd_column_type]:'全部类型';
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部类型" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}