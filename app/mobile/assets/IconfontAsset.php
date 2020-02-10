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

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/iconfont.css'
        // '//at.alicdn.com/t/font_936824_6w2yxssst5o.css',//外部资源或者web可访问资源
    ];
    
    public $js = [];
    
    public $depends = [];
}