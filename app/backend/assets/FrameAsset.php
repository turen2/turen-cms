<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\assets;

use yii\web\AssetBundle;

class FrameAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/frame/';
    
    public $css = [
        'frame.css'
    ];
    
    public $js = [
        'frame.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
