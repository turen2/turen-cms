<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppBanjiaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/global.css',//重置样式
        'css/common.css',//全局通用样式，包括头和尾样式
        'css/layout.css',//页面布局样式
        'css/content.css',//内容与列表详情样式
        'css/sidebox.css',//侧边栏样式
        'css/unit.css',//独立单元样式
        'css/account.css',//用户中心
    ];
    
    public $js = [
        'js/common.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
