<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main html5 application asset bundle.
 */
class QrcodeAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/qrcode/';
    
    public $css = [
        //
    ];
    
    public $js = [
        'js/jquery.qrcode.min.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
