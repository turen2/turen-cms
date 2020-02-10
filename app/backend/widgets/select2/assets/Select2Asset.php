<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\select2\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $sourcePath = '@app/widgets/select2/assets/select2/';
    
    public $css = [
        'css/select2.min.css',
    ];
    
    public $js = [
        //注意语言包的顺序，一定要在后台引入
        'js/select2.min.js',
        'i18n/zh-CN.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}