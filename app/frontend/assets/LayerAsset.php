<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class LayerAsset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/assets/layer/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    //public $css = [];
    public $js = [
        'layer.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}