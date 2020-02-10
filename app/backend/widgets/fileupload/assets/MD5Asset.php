<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 万国迦南科技
 * @author developer qq:980522557
 */
namespace backend\widgets\fileupload\assets;

use yii\web\AssetBundle;

class MD5Asset extends AssetBundle
{
    //这个属性是设置不能被web访问资源
    public $sourcePath = '@app/widgets/fileupload/assets/md5/';
    
    //这两个则是设置外部资源或者web可访问资源
//     public $basePath = '@webroot';
//     public $baseUrl = '@web';
    
    //public $css = [];
    public $js = [
        'js/md5.min.js',
    ];
    
    //public $depends = [];
}