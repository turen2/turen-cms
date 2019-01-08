<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

class PageController extends \app\components\Controller
{
    /**
     * page详情
     * @return string
     */
    public function actionInfo()
    {
        return $this->render('info');
    }

}
