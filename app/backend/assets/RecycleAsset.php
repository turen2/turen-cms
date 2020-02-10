<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\assets;

use yii\web\AssetBundle;

//这个js库，在jquery中已经自带了
class RecycleAsset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/assets/recycle/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    //public $css = [];
    public $js = [
        'js/recycle.js',
    ];
    
    public $depends = [
        //'yii\web\JqueryAsset',
        'backend\assets\NotifyAsset'
    ];
}