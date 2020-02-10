<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public function init()
    {
        parent::init();

        $version = Yii::$app->getVersion();

        // css
        $this->css[] = 'css/style.css?v='.$version;//重置样式

        // js
        $this->js[] = 'js/common.js?v='.$version;
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
