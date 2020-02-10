<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 * Date: 2019/1/9
 * Time: 17:04
 */

use yii\helpers\Url;

$webUrl = Yii::getAlias('@web/');

$str = '';
foreach ($content as $index => $item) {
    $route['slug'] = $item['slug'];
    $active = ($index < 3)?'active':'';
    $str .= '<li><a href="'.Url::to($route).'"><i class="'.$active.'">'.($index + 1).'</i>'.$item['title'].'</a></li>';
}
echo '<ul>'.$str.'</ul>';