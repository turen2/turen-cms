<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_weibo}}".
 *
 * @property string $uid 用户UID
 * @property string $screen_name 用户昵称
 * @property string $name 友好显示名称
 * @property string $province 用户所在省级ID
 * @property int $city 用户所在城市ID
 * @property string $location 用户所在地
 * @property string $description 用户个人描述
 * @property string $profile_image_url 用户头像地址（中图），50×50像素
 * @property string $profile_url
 * @property string $gender 性别，m：男、f：女、n：未知
 * @property int $verified 是否是微博认证用户，即加V用户，1：是，0：否
 * @property string $avatar_large 用户头像地址（大图），180×180像素
 * @property string $avatar_hd 用户头像地址（高清），高清头像原图
 */
class Weibo extends \common\components\ActiveRecord implements AuthLoginInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_weibo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'province', 'city'], 'integer'],
            [['screen_name', 'name'], 'string', 'max' => 60],
            [['location'], 'string', 'max' => 30],
            [['description', 'profile_image_url', 'gender', 'avatar_large', 'avatar_hd'], 'string', 'max' => 255],
            [['profile_url'], 'string', 'max' => 100],
            [['verified'], 'string', 'max' => 1],
            [['uid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户UID',
            'screen_name' => '用户昵称',
            'name' => '友好显示名称',
            'province' => '用户所在省级ID',
            'city' => '用户所在城市ID',
            'location' => '用户所在地',
            'description' => '用户个人描述',
            'profile_image_url' => '用户头像地址（中图），50×50像素',
            'profile_url' => 'Profile Url',
            'gender' => '性别，m：男、f：女、n：未知',
            'verified' => '是否是微博认证用户，即加V用户，1：是，0：否',
            'avatar_large' => '用户头像地址（大图），180×180像素',
            'avatar_hd' => '用户头像地址（高清），高清头像原图',
        ];
    }
    
    /**
     * 统一获取头像
     */
    public function getDisplayAvatar()
    {
        return $this->avatar_large;
    }
    
    /**
     * 统一获取昵称
     */
    public function getDisplayName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     * @return WeiboQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WeiboQuery(get_called_class());
    }
}
