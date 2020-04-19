<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public function init()
    {
        parent::init();

        // css
        $this->css[] = 'css/global.css';//重置样式
        $this->css[] = 'css/common.css';//全局通用样式，包括头和尾样式
        $this->css[] = 'css/layout.css';//页面布局样式
        $this->css[] = 'css/content.css';//内容与列表详情样式
        $this->css[] = 'css/sidebox.css';//侧边栏样式
        $this->css[] = 'css/unit.css';//独立单元样式
        $this->css[] = 'css/account.css';//用户中心

        // js
        $this->js[] = 'js/common.js';
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';

//    public $css = [
//        'css/global.css?',//重置样式
//        'css/common.css?',//全局通用样式，包括头和尾样式
//        'css/layout.css?',//页面布局样式
//        'css/content.css?',//内容与列表详情样式
//        'css/sidebox.css?',//侧边栏样式
//        'css/unit.css?',//独立单元样式
//        'css/account.css?',//用户中心
//    ];
    
//    public $js = [
//        'js/common.js?',
//    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
