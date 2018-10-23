<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use app\models\cms\Column;
use common\helpers\BuildHelper;
use yii\helpers\Url;
use app\models\cms\Cate;

$columnModel = Column::findOne($model->columnid);
$buildFilter = BuildHelper::buildFilter(Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Column::class, 'id', 'parentid', 'cname', true, $type, 'VideoSearch', 'columnid');
if(!empty($buildFilter)) {
    $title = is_null($columnModel)?'全部栏目':$columnModel->cname;
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部栏目" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}

if(Yii::$app->params['config_init_open_cate']) {//是否开启分类
    $cateModel = Cate::findOne($model->cateid);
    $buildFilter = BuildHelper::buildFilter(Cate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), Cate::class, 'id', 'parentid', 'catename', true, null, 'VideoSearch', 'cateid');
    if(!empty($buildFilter)) {
        $title = is_null($cateModel)?'全部分类':$cateModel->catename;
        echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部分类" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
    }
}