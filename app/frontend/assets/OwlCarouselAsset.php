<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/assets/owl-carousel/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    public $css = [
        'css/owl.carousel.css',
        'css/owl.transitions.css',
        'css/owl.theme.css',
    ];
    
    public $js = [
        'js/owl.carousel.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}