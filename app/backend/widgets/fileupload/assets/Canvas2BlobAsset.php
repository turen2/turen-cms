<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload\assets;

use yii\web\AssetBundle;

class Canvas2BlobAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-canvas-to-blob';
    public $js = [
        // <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        "js/canvas-to-blob.min.js",
    ];
}
