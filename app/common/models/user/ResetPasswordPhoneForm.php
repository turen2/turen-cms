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

/**
 * Password reset form
 */
class ResetPasswordPhoneForm extends Model
{
    public $password;
    
    private $_session;

    public function init()
    {
        parent::init();
        
        $this->_session = Yii::$app->getSession();
        $this->_session->open();
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
    
    public function setVerifyCodeAndPhone($verifyCode, $phone)
    {
        $this->_session->set('__phone_phone_code', $verifyCode);
        $this->_session->set('__phone_phone', $phone);
    }
    
    public function existsVerifyCodeAndPhone()
    {
        if (!empty($this->_session->get('__phone_phone_code')) && $this->_session->get('__phone_phone')) {
            return true;
        } else {
            return false;
        }
    }
    
    public function clear()
    {
        if(isset($this->_session['__phone_phone_code'])) {
            unset($this->_session['__phone_phone_code']);
        }
        if(isset($this->_session['__phone_phone'])) {
            unset($this->_session['__phone_phone']);
        }
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $password = Yii::$app->security->generatePasswordHash($this->password);
        Merchant::updateAll(['password_hash' => $password], ['phone' => $this->_session->get('__phone_phone')]);
        $this->clear();
    }
}
