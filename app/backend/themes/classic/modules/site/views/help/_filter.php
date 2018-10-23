<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
use common\helpers\BuildHelper;
use yii\helpers\Url;
use app\models\site\HelpCate;

$helpCateModel = HelpCate::findOne($model->cateid);
$buildFilter = BuildHelper::buildFilter(HelpCate::find()->orderBy(['orderid' => SORT_DESC])->all(), HelpCate::class, 'id', 'parentid', 'catename', true, null, 'HelpSearch', 'cateid');
if(!empty($buildFilter)) {
    $title = is_null($helpCateModel)?'全部分类':$helpCateModel->catename;
    echo '<span class="alltype"><a href="'.Url::to(['index']).'" title="点击查看全部分类" class="btn">'.$title.' <i class="fa fa-angle-down"></i></a><span class="drop">'.$buildFilter.'</span></span>';
}