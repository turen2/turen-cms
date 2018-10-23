<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\assets;

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
