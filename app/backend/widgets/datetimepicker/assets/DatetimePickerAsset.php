<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\datetimepicker\assets;

use yii\web\AssetBundle;

class DatetimePickerAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/datetimepicker/assets/datetimepicker/';
    
    public $css = [
        'jquery.datetimepicker.min.css'
    ];
    
    public $js = [
        'jquery.datetimepicker.full.min.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}