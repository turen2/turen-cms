<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

class FaqsController extends \app\components\Controller
{
    /**
     * 问答页面
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 提交新问答
     * @return string
     */
    public function actionAsk()
    {
        return $this->render('ask');
    }
}