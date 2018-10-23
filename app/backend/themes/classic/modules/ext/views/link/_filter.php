<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use common\helpers\BuildHelper;
use yii\helpers\Url;
use app\models\ext\LinkType;

$linkTypeModel = LinkType::findOne($model->link_type_id);
$buildFilter = BuildHelper::buildFilter(LinkType::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), LinkType::class, 'id', 'parentid', 'typename', true, null, 'LinkSearch', 'link_type_id');
if(!empty($buildFilter)) {
    $title = is_null($linkTypeModel)?'全部类别':$linkTypeModel->typename;
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部类别" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}
