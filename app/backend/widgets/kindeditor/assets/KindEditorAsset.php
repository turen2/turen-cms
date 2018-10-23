<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\kindeditor\assets;

use yii\web\AssetBundle;

class KindEditorAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/kindeditor/assets/kindeditor/';
    
    public $css = [
        //
    ];
    
    public $js = [
        //注意语言包的顺序，一定要在后台引入
        'kindeditor-min.js',
        'lang/zh_CN.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}