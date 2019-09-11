<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class YetiiAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/yetii/';
    
    public $css = [];
    
    public $js = [
        'yetii-min.js'
    ];
    
//    public $depends = [
//        'yii\web\JqueryAsset',
//    ];
}
