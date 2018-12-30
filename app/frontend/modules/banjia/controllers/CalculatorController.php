<?php

namespace app\modules\banjia\controllers;

class CalculatorController extends \app\components\Controller
{
    /**
     * 计算器，计算所有项目的价格，并提交邮件快速预约
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 预约订单
     * @return string
     */
    public function actionPreOder()
    {
        return $this->render('pre-order');
    }
}
