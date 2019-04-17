<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user\user;

use Yii;
use yii\base\Model;
use common\models\user\User;

/**
 * Bind form
 */
class BindForm extends Model
{
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;
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
            [['email', 'password', 'rePassword', 'verifyCode', 'protocol'], 'required'],
            ['email', 'trim'],
            ['email','email'],
            ['password', 'string', 'min' => 6],
            ['rePassword','compare','compareAttribute'=>'password', 'message' => '再次输入的密码不一致'],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'account/user/captcha',
            ],
            ['protocol', 'validateProtocol'],
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
            'email' => '用户邮件',
            'password' => '密码',
            'rePassword' => '确认密码',
            'verifyCode' => '验证码',
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
        $user->username = empty($name)?$this->email:$name;
        $user->avatar = $tmodel->getDisplayAvatar();
        $user->{$field} = $openid;
        $user->email = $this->email;
        //$user->address_prov = $this->province;
        //$user->address_city = $this->city;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);
        return $user;
    }

    /*
    public function bind()
    {
        $user = Yii::$app->getUser()->getIdentity();
        $user->email = $this->email;
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
