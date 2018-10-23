<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
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