<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\site\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\sys\Admin;
use backend\components\Controller;
use backend\models\sys\form\Login;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    
    public function init()
    {
        Yii::$app->layout = 'login-main';//当前模块使用指定布局
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'signup' => ['POST'],
                ],
            ],
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
                'width' => 120,
                'height' => 40,
                'padding' => 4,
                'transparent' => true,
                'foreColor' => 0x62A8EA,
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 0,//每个字母相隔像素
                'fontFile' => '@app/web/fonts/WishfulWaves.ttf',
            ],
        ];
    }
    
    /**
     * Login
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();//正常到登录后的首页
        }
        
        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {//登录操作
            return $this->goBack();//重，返回到之前所在页面，或者是上次请求的那个页面
            //它是与Yii::$app->user->loginRequired()配合的一个方法
        } else {
            //登录界面
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Logout
     * @return string
     * 后期考虑一下ajax、pjax
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
        //return $this->goHome();
        //return Yii::$app->user->loginRequired();//直接跳转到登录，这个会记录当前访问，会影响再次登录
    }
    
    /**
     * Signup new user
     * @return string
     */
    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();//跳转到首页，不是登录状态，又跳转到登录页面
            }
        }
        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    /**
     * Request reset password
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
        
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    
    /**
     * Reset password
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', '新密码已经保存。');
            return $this->goHome();
        }
        
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    /**
     * Reset password
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return $this->goHome();
        }
        
        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求页面不存在！');
    }
}
