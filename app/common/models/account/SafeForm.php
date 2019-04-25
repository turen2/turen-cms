<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use Yii;
use yii\base\Model;
use common\models\user\User;
use common\emailcode\EmailCodeValidator;
use common\phonecode\PhoneCodeValidator;

/**
 * safe form
 */
class SafeForm extends Model
{
    //修改密码
    public $currentPassword;
    public $password;
    public $rePassword;

    //绑定手机号码
    //当前密码
    public $phone;//新手机号码
    public $phoneCode;//手机验证码

    //绑定邮件
    //当前密码
    public $email;//新用户邮件
    public $emailCode;//邮件验证码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['currentPassword', 'validateCurrentPassword', 'on' => ['update_password', 'bind_phone', 'bind_email']],

            [['currentPassword', 'password', 'rePassword'], 'trim', 'on' => 'update_password'],
            [['currentPassword', 'password', 'rePassword'], 'required', 'on' => 'update_password'],
            [['currentPassword', 'password', 'rePassword'], 'string', 'min' => 6, 'on' => 'update_password'],//方式一，直接用on指定场景
            ['password', 'compare', 'compareAttribute' => 'rePassword', 'operator' => '==', 'on' => 'update_password'],

            [['currentPassword'], 'trim', 'on' => 'bind_phone'],
            [['phone', 'phoneCode'], 'required', 'on' => 'bind_phone'],
            ['phone', 'unique',
                'targetClass' => User::class,
                'filter' => ['not', ['user_id' => Yii::$app->getUser()->getIdentity()->getId()]],//排除自身
                'on' => 'bind_phone',
            ],
            ['phone', 'validateEqualityCurrentPhone', 'on' => 'bind_phone'],
            ['phoneCode', PhoneCodeValidator::class, 'phoneAttribute' => 'phone', 'on' => 'bind_phone'],//自定义手机验证码

            [['currentPassword'], 'trim', 'on' => 'bind_email'],
            [['email', 'emailCode'], 'required', 'on' => 'bind_email'],
            ['email', 'unique',
                'targetClass' => User::class,
                'filter' => ['not', ['user_id' => Yii::$app->getUser()->getIdentity()->getId()]],//排除自身
                'on' => 'bind_email',
            ],
            ['email', 'validateEqualityCurrentEmail', 'on' => 'bind_email'],
            ['emailCode', EmailCodeValidator::class, 'emailAttribute' => 'email', 'on' => 'bind_email'],//自定义手机验证码
        ];

        return $rules;
    }

    //方式二，在场景方法中整理不同场景，默认为default场景
//    public function scenarios()
//    {
//        return parent::scenarios();
//    }

    /**
     * 验证当前密码是否正常
     * @param $attribute
     * @param $params
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->getUser()->getIdentity();
            if (!$user || !$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, '当前密码错误，请重试');
            }
        }
    }

    /**
     * 验证是否等于当前手机号码
     * @param $attribute
     * @param $params
     */
    public function validateEqualityCurrentPhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->getUser()->getIdentity();
            if($user) {
                if ($user->phone == $this->phone) {
                    $this->addError($attribute, '新手机号码与当前手机号码重复，请重试');
                }
            }
        }
    }

    /**
     * 验证是否等于当前邮箱
     * @param $attribute
     * @param $params
     */
    public function validateEqualityCurrentEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->getUser()->getIdentity();
            if($user) {
                if ($user->email == $this->email) {
                    $this->addError($attribute, '新邮箱与当前邮箱重复，请重试');
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'currentPassword' => '当前密码',
            'password' => '新密码',
            'rePassword' => '确认密码',
            'phone' => '新手机号码',
            'phoneCode' => '手机验证码',
            'email' => '新邮箱地址',
            'emailCode' => '邮件验证码',
        ];

        return $labels;
    }
}