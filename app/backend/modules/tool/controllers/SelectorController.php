<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\modules\tool\controllers;

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