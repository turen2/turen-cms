<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class IconfontAsset extends AssetBundle
{
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    public $css = [
        '//at.alicdn.com/t/font_936824_2vkcf3gumih.css',
    ];
    
    public $js = [];
    
    public $depends = [];
}