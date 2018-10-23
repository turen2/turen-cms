<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\ueditor;

use yii\web\AssetBundle;

class UEditorAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/ueditor/assets/';
    
    //public $css = [];
    
    public $depends = ['yii\web\JqueryAsset'];
   
    public function init()
    {
        $this->js[] = 'ueditor.config.js';//核心配置
        
        if (YII_DEBUG) {
            $this->js[] = 'ueditor.all.js';
        } else {
            $this->js[] = 'ueditor.all.min.js';
        }
    }
}