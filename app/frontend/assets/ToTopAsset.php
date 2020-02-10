<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ToTopAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/totop/';

    public $css = [];
    
    public $js = [
        'js/jquery.toTop.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
