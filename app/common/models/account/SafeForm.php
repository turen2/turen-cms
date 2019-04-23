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

/**
 * safe form
 */
class SafeForm extends Model
{
    //修改密码
    public $currentPassword;
    public $password;
    public $rePassword;

    //安全问题


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['currentPassword', 'password', 'rePassword'], 'required', 'on' => 'password'],
            [['currentPassword', 'password', 'rePassword'], 'string', 'min' => 6, 'on' => 'password'],
        ];

        return $rules;
    }

//    public function scenarios()
//    {
//        return parent::scenarios();
//    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'currentPassword' => '当前密码',
            'password' => '新密码',
            'rePassword' => '确认密码',
        ];

        return $labels;
    }
}