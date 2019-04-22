<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

/**
 * 第三方登录
 * Class MsgController
 * @package app\modules\account\controllers
 */
class ThirdController extends \app\components\Controller
{
    public function actionList()
    {
        $list = [];
        return $this->render('list', [
            'list' => $list
        ]);
    }
}