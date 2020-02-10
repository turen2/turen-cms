<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\assets;

use yii\web\AssetBundle;

class BaiduTplAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/baidu-tpl/';
    
    public $css = [];
    
    public $js = [
        'baiduTemplate.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
