<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 万国迦南科技
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload\assets;

use yii\web\AssetBundle;

class Canvas2BlobAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/fileupload/assets/blueimp-canvas-to-blob';
    public $js = [
        // <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        "js/canvas-to-blob.min.js",
    ];
}
