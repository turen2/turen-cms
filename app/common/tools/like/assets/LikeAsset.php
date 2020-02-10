<?php

namespace common\tools\like\assets;

use yii\web\AssetBundle;

class LikeAsset extends AssetBundle
{
    public $sourcePath = '@common/tools/like/assets/like/';
    
    public $css = [];
    
    public $js = ['js/like.js'];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}


