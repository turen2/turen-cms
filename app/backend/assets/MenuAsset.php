<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\assets;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/menu/';
    
    public $css = [
        'menu.css',
    ];
    
    public $js = [
        'tinyscrollbar.js',
        'leftmenu.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
