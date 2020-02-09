<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class PaceAsset extends AssetBundle
{
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public $sourcePath = '@app/assets/pace/';
    
    public $css = [
        'css/pace-theme-flash.css'
    ];
    
    public $js = [
        'js/pace.min.js'
        // ['js/pace.min.js', ['position' => View::POS_HEAD]]
    ];
}
