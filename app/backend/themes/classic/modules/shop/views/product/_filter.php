<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\helpers\BuildHelper;
use backend\models\shop\ProductCate;

$addRoutes = [
    Html::getInputName($model, 'status') => $model->status,
    Html::getInputName($model, 'flag') => $model->flag,
    Html::getInputName($model, 'keyword') => $model->keyword
];

$cateModel = ProductCate::findOne($model->pcateid);
$buildFilter = BuildHelper::buildFilter(ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), ProductCate::class, 'id', 'parentid', 'cname', true, null, 'ProductSearch', 'pcateid', $addRoutes);
if(!empty($buildFilter)) {
    $title = is_null($cateModel)?'全部分类':$cateModel->cname;
    echo '<span class="alltype"><a href="'.Url::to(ArrayHelper::merge(['index'], $addRoutes)).'" title="点击查看全部分类" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}