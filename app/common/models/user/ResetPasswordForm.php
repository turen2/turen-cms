<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\user\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \common\models\user\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = Merchant::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
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
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return Merchant::updateAll(['password_hash' => $user->password_hash], ['id' => $user->id]);
    }
}
