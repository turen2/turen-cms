<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload\assets;

use yii\web\AssetBundle;

class jQueryFileUploadPlusAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-file-upload';
    public $js = [
        // <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        "js/jquery.iframe-transport.js",
        // <!-- The File Upload processing plugin -->
        "js/jquery.fileupload-process.js",
        // <!-- The File Upload image preview & resize plugin -->
        "js/jquery.fileupload-image.js",
        // <!-- The File Upload audio preview plugin -->
        "js/jquery.fileupload-audio.js",
        // <!-- The File Upload video preview plugin -->
        "js/jquery.fileupload-video.js",
        // <!-- The File Upload validation plugin -->
        "js/jquery.fileupload-validate.js"
    ];
    public $depends = [
        'app\widgets\fileupload\assets\JQueryFileUploadAsset',
        'app\widgets\fileupload\assets\LoadImageAsset',
        'app\widgets\fileupload\assets\Canvas2BlobAsset'
    ];
}
