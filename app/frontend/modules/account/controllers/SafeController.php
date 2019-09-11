<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use common\emailcode\EmailCodeAction;
use Yii;
use common\models\account\SafeForm;
use common\models\user\User;
use common\phonecode\PhoneCodeAction;

/**
 * 安全中心
 * Class SafeController
 * @package app\modules\account\controllers
 */
class SafeController extends \app\components\Controller
{
    public function actions()
    {
        $phone = Yii::$app->getRequest()->get('phone');//ajax手机号码
        $signTemplate = Yii::$app->getRequest()->get('signTemplate');//短信签名模板
        $email = Yii::$app->getRequest()->get('email');//ajax邮箱地址
        return [
            //发送手机验证码
            'phone-code' => [
                'class' => PhoneCodeAction::class,
                'verifycode' => false,//不需要图型验证码
                'phone' => $phone,
                'maxNum' => 6,
                'signTemplate' => $signTemplate,
            ],
            //发送邮箱验证码
            'email-code' => [
                'class' => EmailCodeAction::class,
                'verifycode' => false,//不需要图型验证码
                'email' => $email,
                'maxNum' => 6,
            ],
        ];
    }

    /**
     * 安全中心列表页
     * @return string
     * @throws \Throwable
     */
    public function actionInfo()
    {
        $model = new SafeForm();
        return $this->render('info', [
            'model' => $model,
            'userModel' => Yii::$app->getUser()->getIdentity(),
        ]);
    }

    /**
     * 更新用户密码
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
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

    /**
     * 绑定新手机号码
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionBindPhone()
    {
        $model = new SafeForm(['scenario' => 'bind_phone']);
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            //修改
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                'phone' => $model->phone,
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
            'msg' => '新手机号码绑定成功',
        ]);
    }

    /**
     * 绑定新邮箱
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionBindEmail()
    {
        $model = new SafeForm(['scenario' => 'bind_email']);
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            //修改
            Yii::$app->getDb()->createCommand()->update(User::tableName(), [
                'email' => $model->email,
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
            'msg' => '新邮箱绑定成功',
        ]);
    }
}