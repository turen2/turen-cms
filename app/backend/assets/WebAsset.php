<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

class WebAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/admin.css',
        'css/site.css',
    ];
    
    public $js = [
        'js/site.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
