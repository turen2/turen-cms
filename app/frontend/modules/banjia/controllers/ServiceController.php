<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\banjia\controllers;

class ServiceController extends \app\components\Controller
{
    /**
     * 服务详情
     * @return string
     */
    public function actionDetail()
    {
        return $this->render('detail');
    }

    /**
     * 生成咨询单，并发短信，邮件，微信通知等
     * @return string
     */
    public function actionConsult()
    {
        return $this->render('consult');
    }
}
