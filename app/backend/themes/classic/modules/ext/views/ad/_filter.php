<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use common\helpers\BuildHelper;
use yii\helpers\Url;
use app\models\ext\AdType;

$adTypeModel = AdType::findOne($model->ad_type_id);
$buildFilter = BuildHelper::buildFilter(AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), AdType::class, 'id', 'parentid', 'typename', true, null, 'AdSearch', 'ad_type_id');
if(!empty($buildFilter)) {
    $title = is_null($adTypeModel)?'全部广告位':$adTypeModel->typename;
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部广告位" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}
