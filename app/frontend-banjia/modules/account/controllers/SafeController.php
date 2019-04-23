<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use common\models\user\User;
use Yii;
use common\models\account\SafeForm;

/**
 * 安全中心
 * Class MsgController
 * @package app\modules\account\controllers
 */
class SafeController extends \app\components\Controller
{
    public function actionInfo()
    {
        $model = new SafeForm(['scenario' => 'password']);
        //$userModel = Yii::$app->getUser()->getIdentity();

        return $this->render('info', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePassword()
    {
        $model = new SafeForm(['scenario' => 'password']);
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userModel = Yii::$app->getUser()->getIdentity();
            //修改
            $userModel->setPassword($model->password);
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                'password_hash' => $userModel->password_hash,
            ], ['user_id' => Yii::$app->getUser()->getId()])->execute();
        } else {
            var_dump($model->getErrors());
        }

        return $this->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '密码修改成功',
        ]);
    }
}