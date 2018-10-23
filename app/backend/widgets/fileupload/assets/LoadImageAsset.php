<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload\assets;

use yii\web\AssetBundle;

class LoadImageAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-load-image';
    public $js = [
        // <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        "js/load-image.all.min.js",
    ];
}
