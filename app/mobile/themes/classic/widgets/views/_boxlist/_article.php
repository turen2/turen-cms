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

$webUrl = Yii::getAlias('@web/');

$str = '';
foreach ($content as $index => $item) {
    $route['slug'] = $item['slug'];
    $title = $item['title'];

    if(empty($item['description'])) {
        $des = $item['content'];//去除图片链接
    } else {
        $des = $item['description'];
    }
    $subtitle = strip_tags($des);

    $url = Url::to($route);
    $time = Yii::$app->getFormatter()->asDate($item['posttime'], 'php:Y-m-d');
    $img = empty($item['picurl'])?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($item['picurl'], true);

    $pic = empty($item['picurl'])?'':'<div class="related-pic"><img src="'.$img.'" style="height: 1.29rem;"></div>';
    $style = empty($item['picurl'])?'style=" width: 100%;padding-left: .1rem;"':'';

    $str .= <<<EOF
<li>
    <a href="{$url}">
        {$pic}
        <div class="related-text"{$style}>
            <h3>{$title}</h3>
            <p>{$subtitle}</p>
            <dl>
                <dd>{$time}</dd>
            </dl>
        </div>
    </a>
</li>
EOF;
}

echo '<ul>'.$str.'</ul>';