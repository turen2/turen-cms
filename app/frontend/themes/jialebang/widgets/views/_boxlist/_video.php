<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/9
 * Time: 17:04
 */

use yii\helpers\Url;
use common\helpers\ImageHelper;

$str = '';
foreach ($content as $index => $item) {
    $route['slug'] = $item['slug'];
    $str .= '<li class="'.(($index%2 == 1)?'last-left':'').'">'.
        '<a title="'.$item['title'].'" href="'.Url::to($route).'">'.
        '<img src="'.(empty($item['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($item['picurl'], true)).'" />'.
        '<p>'.$item['title'].'<span></span></p></a></li>';
}
echo '<ul class="clearfix">'.$str.'</ul>';