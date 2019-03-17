<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

/**
 * 服务订单管理
 * Class OrderController
 * @package app\modules\account\controllers
 */
class OrderController extends \app\components\Controller
{
    public function actionList()
    {
        return $this->render('list', [
        ]);
    }
}