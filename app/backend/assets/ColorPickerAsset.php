<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\assets;

use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/colorpicker/';
    
    public $css = [
        'colorpicker.css',
    ];
    
    public $js = [
        //注意语言包的顺序，一定要在后台引入
        'colorpicker.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}