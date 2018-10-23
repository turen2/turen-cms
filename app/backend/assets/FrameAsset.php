<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\assets;

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
