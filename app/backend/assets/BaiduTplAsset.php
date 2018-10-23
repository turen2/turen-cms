<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\assets;

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
