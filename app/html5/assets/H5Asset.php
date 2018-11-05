<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main html5 application asset bundle.
 */
class H5Asset extends AssetBundle
{
    public $sourcePath = '@app/assets/h5/';
    
    public $css = [
        'css/iconfont.css',
        'css/tui.min.css',
    ];
    
    public $js = [
        //
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
