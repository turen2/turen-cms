<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use app\models\cms\Column;

$columTypes = Column::ColumnTypeNameList();
$typeName = Column::ColumnTypeNameList($model->type);

$title = is_string($typeName)?$typeName:'全部类型';

$list = '';
foreach ($columTypes as $type => $name) {
    $list .= '<a href="'.Url::to(['index', 'FlagSearch'.'[type]' => $type]).'">'.$name.'</a>';
}

echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部类型" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$list.'</span></span>';