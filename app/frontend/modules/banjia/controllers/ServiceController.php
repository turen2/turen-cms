<?php

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
