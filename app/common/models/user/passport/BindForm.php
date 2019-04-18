<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\passport;

use Yii;
use yii\base\Model;
use common\models\user\User;
use common\phonecode\PhoneCodeValidator;

/**
 * Bind form
 */
class BindForm extends Model
{
    public $phone;
    public $password;
    public $rePassword;
    public $verifyCode;
    public $phoneCode;
    public $protocol = true;//协议
    
    //场景
    /*
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_BIND_HAVE] = ['email', 'protocol','verifyCode'];
        $scenarios[static::SCENARIO_BIND_NOT_HAVE] = ['email', 'password', 'rePassword', 'province', 'city','verifyCode'];
        return $scenarios;
    }
    */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'password', 'rePassword', 'phoneCode', 'protocol'], 'required'],
            ['phone', 'trim'],
            ['phone', 'match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            ['phone', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ON],
                'message' => '您输入的手机号码有误，请重试。',
            ],
            ['password', 'string', 'min' => 6],
            ['rePassword','compare','compareAttribute'=>'password', 'message' => '再次输入的密码不一致'],
            ['protocol', 'validateProtocol'],
            ['phoneCode', PhoneCodeValidator::class],//自定义验证器
//            ['verifyCode', 'captcha',
//                'skipOnEmpty' => false,
//                'caseSensitive' => false,
//                'captchaAction' => 'account/passport/captcha',
//            ],
        ];
    }

    //单选验证，方案二
    public function validateProtocol($attribute)
    {
        if(empty($this->$attribute)) {
            $this->addError($attribute, '请务必遵守平台协议！');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => '手机号码',
            'password' => '密码',
            'rePassword' => '确认密码',
            'verifyCode' => '图形验证码',
            'phoneCode' => '手机验证码',
            'protocol' => '商户协议',
        ];
    }

    /**
     * 依照不同的场景保存不同的数据
     * @param string $scenario
     */
    public function bindLogin($id, $openid, $tmodel)
    {
        //直接绑定不严谨，会导致绑定非自己的邮件漏洞，推荐使用手机号+手机验证码
        $field = $id.'_id';
        //注册新账号，并绑定第三方登录
        $name = $tmodel->getDisplayName();
        $user = new User();
        $user->username = empty($name)?$this->phone:$name;
        $user->avatar = $tmodel->getDisplayAvatar();
        $user->{$field} = $openid;
        $user->phone = $this->phone;
        //$user->address_prov = $this->province;
        //$user->address_city = $this->city;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);

        $this->transferUserData($user, $tmodel);

        return $user;
    }

    /**
     * 用户资料转移
     * @param $user
     * @param $tmodel
     * @return bool
     */
    protected function transferUserData($user, $tmodel)
    {
        //'$tmodel'=>$user

        //基本资料

        //预约资料

        //订单资料

        //资质资料

        return true;
    }

    /*
    public function bind()
    {
        $user = Yii::$app->getUser()->getIdentity();
        $user->phone = $this->phone;
        $user->username = '';//注册不用填写姓名
        //$user->address_prov = $this->province;
        //$user->address_city = $this->city;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if($user->save(false)) {
            return $user;
        } else {
            return null;
        }
    }
    */
}
