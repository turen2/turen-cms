<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\calendar\assets;

use yii\web\AssetBundle;

class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/calendar/assets/calendar/';
    
    public $css = [
        'calendar-blue.css',
    ];
    
    public $js = [
        //注意语言包的顺序，一定要在后台引入
        'calendar.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}