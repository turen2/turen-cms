<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\assets;

use yii\web\AssetBundle;

class Swiper2Asset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/assets/swiper2/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    public $css = [
        'css/idangerous.swiper.css',
    ];
    
    public $js = [
        'js/idangerous.swiper.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}