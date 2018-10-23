<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/login.css',
    ];
    
    public $js = [
        'js/site.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
