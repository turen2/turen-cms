<?php

namespace common\tools\share\assets;

use yii\web\AssetBundle;

class ShareAsset extends AssetBundle
{
    public $sourcePath = '@common/tools/share/assets/share/';
    
    public $css = ['css/share.min.css'];
    
    public $js = ['js/jquery.share.min.js'];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}


