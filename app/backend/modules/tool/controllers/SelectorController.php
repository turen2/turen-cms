<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\tool\controllers;

use yii\web\Controller;

/**
 * Default controller for the `tool` module
 */
class SelectorController extends Controller
{
    /**
     * 全局url选择器
     * @return string
     */
    public function actionUrl($param = [])
    {
        
        //$param
        
        $urls = [];
        
        return $this->renderAjax('url', $urls);
    }
}