<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 万国迦南科技
 * @author developer qq:980522557
 */
namespace backend\widgets\fileupload\assets;

use yii\web\AssetBundle;

class LoadImageAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/fileupload/assets/blueimp-load-image';
    public $js = [
        // <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        "js/load-image.all.min.js",
    ];
}
