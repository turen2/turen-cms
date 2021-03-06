<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\modules\account\controllers;

use Yii;
use yii\authclient\BaseClient;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use common\models\user\User;
use common\models\user\passport\LoginForm;
use common\models\user\passport\PhoneLoginForm;
use common\models\user\passport\SignupForm;
use common\models\user\passport\ForgetForm;
use common\models\user\passport\ResetForm;
use common\models\user\passport\BindForm;
use common\phonecode\PhoneCodeAction;
use common\actions\ValidateCaptchaAction;

/**
 * Passport controller
 */
class PassportController extends \frontend\components\Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->view->hideHeaderTop = true;

        //模式判断
        if(Yii::$app->params['config_login_mode'] != User::USER_PHONE_MODE) {
            throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist!'));
        }
    }

    //允许无条件通过验证
    public function allowAction()
    {
        return [
            'login',
            'quick',
            'signup',
            'logout',
            'captcha',
            'validate-captcha',//验证图片验证码
            'phone-code',//发短信验证码
            'forget',//邮箱发送验证邮件
            'reset',//邮箱重新密码
            'forget-result',//密码找回响应结果

            //第三方验证与绑定
            'auth',
            'bind',
            'auth-result',
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $phone = Yii::$app->getRequest()->get('phone');//ajax手机号码
        $verifycode = Yii::$app->getRequest()->get('verifycode');//图形验证码
        $signTemplate = Yii::$app->getRequest()->get('signTemplate');//短信签名模板
        return [
            //生成图片验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 90,
                'height' => 38,
                'padding' => 6,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4,
                'transparent' => true,
                'backColor' => 0xFFFFFF,
                'foreColor' => 0xFF6F20,
                'fontFile' => '@app/web/fonts/WishfulWaves.ttf',
            ],
            //验证图片验证码
            'validate-captcha' => [
                'class' => ValidateCaptchaAction::class,
                'verifycode' => $verifycode,
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/passport/captcha',
            ],
            //发送手机验证码
            'phone-code' => [
                'class' => PhoneCodeAction::class,
                'verifycode' => $verifycode,
                'phone' => $phone,
                'maxNum' => 6,
                'signTemplate' => $signTemplate,
            ],
            //第三方登录

            //请求
            //http://jialebang100.com/account/user/auth?authclient=weibo
            //http://jialebang100.com/account/user/auth?authclient=qq
            //回调
            //http://jialebang100.com/account/user/auth.html?q=account%2Fuser%2Fauth.html&authclient=weibo
            //http://jialebang100.com/account/user/auth?q=account/user/auth&authclient=qq
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                //'redirectView' => '',//指定跳转模板
                'successCallback' => [$this, 'successCallback'],//验证成功回调处理
                'cancelCallback' => [$this, 'cancelCallback'],//取消之后执行的回调
                'successUrl' => Url::to(['passport/auth-result', 'title' => '授权成功并已登录', 'text' => '授权成功并已登录']),//默认跳转
                'cancelUrl' => Url::to(['passport/auth-result', 'title' => '已取消授权登录', 'text' => '已取消授权登录']),
            ],
        ];
    }

    /**
     * 登录成功的回调操作
     *
     * @param QqAuth|WeiboAuth|WxAuth $client
     * @see http://wiki.connect.qq.com/get_user_info
     * @see http://stuff.cebe.cc/yii2docs/yii-authclient-authaction.html
     */
    public function successCallback(BaseClient $client) {
        $id = $client->getId(); // qq | weibo | wx
        $openid = $client->getOpenid(); //user openid
        $attributes = $client->getUserAttributes(); // basic info
        $userInfo = $client->getUserInfo(); // user extend info

        //qq_id//weibo_id//weixin_id
        $securityData = [
            'id' => $id,
            'openid' => $openid,
        ];
        $field = $id.'_id';
        $token = Yii::$app->getSecurity()->hashData(Json::encode($securityData), Yii::$app->params['config.thirdBindRemark']);

        //会话标记，保证整个第三方登录在同一会话中！
        Yii::$app->getSession()->set('_oauth_bind', true);

        //收集第三方信息
        if(empty(User::FindAuthData($id, $openid))) {
            User::BindAuthData($id, $openid, $userInfo);
        }

        //用户中心绑定bind操作
        //if(Yii::$app->getRequest()->get('action', null) == 'bind') {
        if(empty(Yii::$app->getUser()->isGuest)) {
            $this->action->successUrl = Url::to(['/account/third/bind', 'token' => $token]);
            return true;
        }

        //处理绑定
        $user = User::findOne([$field => $openid]);//查询用户，是否绑定，并登录
        if(empty($user)) {
            //没有用户信息！绑定并注册//且防篡改
            $this->action->successUrl = Url::to(['passport/bind', 'token' => $token]);
        } else {
            //已经绑定的用户，进入此控制器即表示授权完成，直接回调为true即可
            Yii::$app->getUser()->login($user, 30 * 24 * 3600);//30天有效//Yii::$app->params['user.effectivetime']
        }

        return true;
    }

    /**
     * 取消并回调
     * @param QqAuth|WeiboAuth|WxAuth $client
     * @return boolean
     */
    public function cancelCallback($client)
    {
        var_dump('cancelCallback测试...');
        return true;

        //记录错误

        //发送邮件

        //退出操作

        //写入持久层

        //跳转到登录页面

        //显示出持久层错误信息
    }

    /**
     * 第三方登录回调，手机号码绑定操作
     * @param string $id
     * @param string $openid
     */
    public function actionBind($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $data = Yii::$app->security->validateData(urldecode($token), Yii::$app->params['config.thirdBindRemark']);
        if(empty($data) || !Yii::$app->getSession()->get('_oauth_bind', false)) {
            throw new NotAcceptableHttpException('非法操作请求将不会处理！');
        }

        $data = Json::decode($data);
        $id = $data['id'];
        $openid = $data['openid'];

        $tmodel = User::FindAuthData($id, $openid);
        if(empty($tmodel)) {
            throw new NotAcceptableHttpException('非法操作请求将不会处理！');
        }

        $model = new BindForm();
        if($post = Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if($model->validate()) {
                $user = $model->bindLogin($id, $openid, $tmodel);
                //绑定完，马上登录
                Yii::$app->getUser()->login($user, 30 * 24 * 3600);
                Yii::$app->getSession()->remove('_oauth_bind');

                return $this->redirect(['passport/auth-result', 'title' => '绑定成功并已经登录', 'text' => '绑定成功并已经登录']);//绑定成功页面
            }
        }

        return $this->render('bind', [
            'model' => $model,
            'token' => $token,
            'tmodel' => $tmodel,
        ]);
    }

    public function actionAuthResult($title, $text)
    {
        return $this->render('auth-result', [
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Logs in a user by account.
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
     * Logs in a user by phone.
     *
     * @return mixed
     */
    public function actionQuick()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PhoneLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('quick', [
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * 忘记密码
     * @return mixed
     */
    public function actionForget()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new ForgetForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($token = $model->generateToken()) {
                return $this->redirect(['passport/reset', 'token' => $token]);
            } else {
                return $this->redirect(['passport/forget-result', 'type' => 'error', 'point' => 2, 'title' => '找回密码失败', 'text' => '找回密码失败，请稍后再试']);
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        try {
            $model = new ResetForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            return $this->redirect(['passport/forget-result', 'type' => 'success', 'point' => 4, 'title' => '密码重置成功', 'text' => '密码重置成功，请使用新密码登录']);
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
    public function actionForgetResult($type = 'success', $title = '', $text = '', $point = 1)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('forget-result', [
            'type' => $type,
            'title' => $title,
            'text' => $text,
            'point' => $point,
        ]);
    }
}