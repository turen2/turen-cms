<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use common\models\user\VerifyCodeForm;
use common\models\user\LoginForm;
use common\models\user\SignupForm;
use common\models\user\ForgetForm;
use common\models\user\ResetForm;

/**
 * User controller
 */
class UserController extends \app\components\Controller
{
    //允许无条件通过验证
    public function allowAction()
    {
        return [
            'login',
            'signup',
            'logout',
            'captcha',
            'error',
            'forget',//邮箱发送验证邮件
            'reset',//邮箱重新密码
            'result',//响应结果
            'phone-password',//手机重置密码
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 100,
                'height' => 42,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }

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

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        //$verifyModel = new VerifyCodeForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            //'verifyModel' => $verifyModel,
        ]);
    }

    /**
     * 忘记密码
     * @return mixed
     */
    public function actionForget()
    {
        $model = new ForgetForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return $this->redirect(['user/result', 'type' => 'success', 'title' => '邮箱发送成功', 'text' => '邮箱已发送，请查收并继续完成下一步操作']);
            } else {
                return $this->redirect(['user/result', 'type' => 'error', 'title' => '邮箱发送失败', 'text' => '发送错误，请输入正确的邮箱地址再试']);
            }
        }

        return $this->render('forget', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionReset($token)
    {
        try {
            $model = new ResetForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            return $this->redirect(['user/result', 'type' => 'success', 'title' => '密码重置成功', 'text' => '密码重置成功，请使用新密码登录']);
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    /**
     * 响应结果页面
     * @param string $type
     * @param string $title
     * @param string $text
     * @return string
     */
    public function actionResult($type = 'success', $title = '', $text = '')
    {
        return $this->render('result', [
            'type' => $type,
            'title' => $title,
            'text' => $text,
        ]);
    }
}