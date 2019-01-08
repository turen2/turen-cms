<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

class NewsController extends \app\components\Controller
{
    /**
     * 新闻列表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 新闻详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('list');
    }
}
