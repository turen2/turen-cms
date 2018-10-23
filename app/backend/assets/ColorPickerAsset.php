<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\assets;

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