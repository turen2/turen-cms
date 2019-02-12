<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;
    public $password;
    public $phoneCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'password', 'phoneCode'], 'required'],
            ['phone', 'trim'],
            ['phone', 'unique', 'targetClass' => '\common\models\user\User'],
            ['phone', 'string', 'min' => 6, 'max' => 20],
            ['phone','match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => '手机号码',
            'password' => '输入密码',
            'phoneCode' => '手机验证码',
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
        
        $user = new User(['scenario' => 'register']);
        $user->name = $this->phone;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
