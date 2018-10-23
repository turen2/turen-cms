<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\laydate\assets;

use yii\web\AssetBundle;

class LaydateAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/laydate/assets/laydate/';
    
    public $css = [
        //自动加载
    ];
    
    public $js = [
        'laydate.js'
    ];
    
    public $depends = [
        //
    ];
}