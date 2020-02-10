<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\assets;

use yii\web\AssetBundle;

class BxsliderAsset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/assets/bxslider/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    public $css = [
        'css/jquery.bxslider.min.css',
    ];
    
    public $js = [
        'js/jquery.bxslider.min.js',
        //'js/jquery.easing.1.3.js',
        //'js/jquery.fitvids.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}