<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use common\models\account\InfoForm;
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
        $model = new InfoForm([
            'sex' => true
        ]);
        return $this->render('info', [
            'userModel' => $userModel,
            'model' => $model,
        ]);
    }
}