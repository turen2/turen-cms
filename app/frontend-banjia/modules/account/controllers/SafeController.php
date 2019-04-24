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
        $model = new SafeForm();
        return $this->render('info', [
            'model' => $model,
            'userModel' => Yii::$app->getUser()->getIdentity(),
        ]);
    }

    public function actionUpdatePassword()
    {
        $model = new SafeForm(['scenario' => 'update_password']);
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            //修改
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                'password_hash' => Yii::$app->security->generatePasswordHash($model->password),
            ], [
                'user_id' => Yii::$app->getUser()->getId(),
            ])->execute();
        } else {
            $error = current($model->getErrors());
            if(isset($error[0])) {
                return $this->asJson([
                    'state' => false,
                    'code' => 200,
                    'msg' => $error[0],
                ]);
            }
        }

        return $this->asJson([
            'state' => true,
            'code' => 200,
            'msg' => '密码修改成功',
        ]);
    }
}