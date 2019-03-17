<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use Yii;

/**
 * Center controller
 */
class CenterController extends \app\components\Controller
{
    /**
     * 用户中心首页
     * @return string
     * @throws \Throwable
     */
    public function actionInfo()
    {
        $userModel = Yii::$app->getUser()->getIdentity();
        $userInfoModel = null;
        return $this->render('info', [
            '$userModel' => $userModel,
            '$userInfoModel' => $userInfoModel,
        ]);
    }
}