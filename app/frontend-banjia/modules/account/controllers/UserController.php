<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\controllers;

use Yii;
use common\models\user\VerifyCodeForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use common\models\user\LoginForm;
use common\models\user\SignupForm;

/**
 * User controller
 */
class UserController extends \app\components\Controller
{
    const SIGNUP_VERIFY_CODE = 'signup_verify_code';

    //允许无条件通过验证
    public function allowAction()
    {
        return [
            'login',
            'signup',
            'logout',
            'forget',
            'captcha',
            'error',
        ];
    }

    /**
     * @inheritdoc
     */
/*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
*/

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $params = Yii::$app->getRequest()->queryParams;
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
            ],
            //获取手机验证码
            /*
            'phone-code' => [
                'class' => PhoneCodePopAction::class,
                'phone' => $params['phone'],
                'maxNum' => 6,
            ],
            */
        ];
    }

    /**
     * Displays homepage.
     * 用户中心首页
     *
     * @return mixed
     */
    public function actionInfo()
    {
        return $this->render('info');
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
        $signupModel = new SignupForm();
        $verifyModel = new VerifyCodeForm();

        if ($signupModel->load(Yii::$app->request->post())) {
            if ($user = $signupModel->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'signupModel' => $signupModel,
            'verifyModel' => $verifyModel,
        ]);
    }

    /**
     * 找回密码
     * @return string
     */
    public function actionForget()
    {
        $model = null;
        return $this->render('forget', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * 验证，注册验证码
     */
    public function actionSignupVerifyCode()
    {
        $verifyModel = new VerifyCodeForm();

        if($verifyModel->load(Yii::$app->request->post()) && $result = $verifyModel->validate()) {
            //验证成功//写入session
            Yii::$app->session->set(self::SIGNUP_VERIFY_CODE, true);
        }

        return $this->asJson($result);
    }

    //Yii::$app->session->set(self::SIGNUP_VERIFY_CODE, true);
    public function actionSendPhoneCode()
    {
        $action = Yii::createObject([
            'class' => PhoneCodePopAction::class,
            'phone' => '13725514524',
            'maxNum' => 6,
        ]);

//        $action = new PhoneCodePopAction([
//
//        ]);

        return $action->run();
    }
}
