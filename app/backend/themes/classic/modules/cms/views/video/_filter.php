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
use backend\models\cms\Column;
use backend\models\cms\Cate;

$addRoutes = [
    Html::getInputName($model, 'keyword') => $model->keyword,
    Html::getInputName($model, 'status') => $model->status,
    Html::getInputName($model, 'flag') => $model->flag,
    Html::getInputName($model, 'author') => $model->author
];

$buildFilter = BuildHelper::buildFilter(Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, $type, 'VideoSearch', 'columnid', ArrayHelper::merge($addRoutes, [Html::getInputName($model, 'cateid') => $model->cateid]));
if(!empty($buildFilter)) {
    $title = is_null($columnModel)?'全部栏目':$columnModel->cname;
    echo '<span class="alltype"><a href="'.Url::to(ArrayHelper::merge(['index', Html::getInputName($model, 'cateid') => $model->cateid], $addRoutes)).'" title="点击查看全部栏目" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}

if(Yii::$app->params['config.openCate']) {//是否开启分类
    $cateModel = Cate::findOne($model->cateid);
    $buildFilter = BuildHelper::buildFilter(Cate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Cate::class, 'id', 'parentid', 'catename', true, null, 'VideoSearch', 'cateid', ArrayHelper::merge($addRoutes, [Html::getInputName($model, 'columnid') => $model->columnid]));
    if(!empty($buildFilter)) {
        $title = is_null($cateModel)?'全部分类':$cateModel->catename;
        echo '<span class="alltype"><a href="'.Url::to(ArrayHelper::merge(['index', Html::getInputName($model, 'columnid') => $model->columnid], $addRoutes)).'" title="点击查看全部分类" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
    }
}