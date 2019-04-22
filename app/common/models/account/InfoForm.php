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
 * Info form
 */
class InfoForm extends Model
{
    public $username;//用户名
    public $telephone;//手机号码
    public $level_id;//用户等级
    public $ug_id;//用户组
    public $avatar;//用户头像
    public $sex;//性别
    public $intro;//自我介绍

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['username', 'avatar', 'sex'], 'required'],
            ['username', 'unique',
                'targetClass' => User::class,
                //'filter' => ['status' => User::STATUS_ON],
            ],
            ['intro', 'string'],
        ];

        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'username' => '用户名',
            'telephone' => '手机号码',
            'level_id' => '用户等级',
            'ug_id' => '用户组',
            'avatar' => '用户头像',
            'sex' => '性别',
            'intro' => '自我介绍',
        ];

        return $labels;
    }
}