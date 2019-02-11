<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;
use common\models\merchant\Merchant;
use common\models\merchant\MerchantGroup;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $phone;
    public $verifyCode;
    public $merchant_group_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\common\models\merchant\Merchant'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            [['phone', 'verifyCode'], 'required'],
            ['phone', 'trim'],
            ['phone', 'unique', 'targetClass' => '\common\models\merchant\Merchant'],
            ['phone', 'string', 'min' => 6, 'max' => 20],
            ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\merchant\Merchant'],//, 'message' => 'This email address has already been taken.'

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyCode', 'captcha',
                'skipOnEmpty' => false,
                'caseSensitive' => false,
                'captchaAction' => 'merchant/common/captcha',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('merchant', 'User Name'),
            'password' => Yii::t('merchant', 'Password'),
            'rememberMe' => Yii::t('merchant', 'Remember Me'),
            'verifyCode' => Yii::t('merchant', 'Verification Code'),
            'email' => Yii::t('merchant', 'Email'),
            'phone' => Yii::t('merchant', 'User Phone'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Merchant(['scenario' => 'register']);
        $user->phone = $this->phone;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //查找默认分组的id存入进去
        $group = MerchantGroup::findOne(['en_default' => MerchantGroup::ON_DEFAULT]);
        $user->merchant_group_id = $group->id;
        
        //save保存之前会进行user的规则验证
        //所以，ActiveRecord Model和FormModel组合的时候，通常做了双重验证
        //一个是用户输入前验证，一个是写入数据库前验证

        return $user->save() ? $user : null;
    }
}
