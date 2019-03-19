<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_qq}}".
 *
 * @property string $uid 就是openid
 * @property string $nickname 用户在QQ空间的昵称。
 * @property string $gender 性别
 * @property string $province 省份
 * @property string $city 城市
 * @property int $year 出生年
 * @property string $figureurl 大小为30×30像素的QQ空间头像URL。
 * @property string $figureurl_1 大小为50×50像素的QQ空间头像URL。
 * @property string $figureurl_2 大小为100×100像素的QQ空间头像URL。
 * @property string $figureurl_qq_1 大小为40×40像素的QQ头像URL。
 * @property string $figureurl_qq_2 大小为100×100像素的QQ头像URL。需要注意，不是所有的用户都拥有QQ的100x100的头像，但40x40像素则是一定会有。
 */
class Qq extends \common\components\ActiveRecord implements AuthLoginInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_qq}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'nickname', 'gender', 'province', 'city', 'year', 'figureurl', 'figureurl_1', 'figureurl_2', 'figureurl_qq_1', 'figureurl_qq_2'], 'required'],
            [['year'], 'integer'],
            [['uid'], 'string', 'max' => 64],
            [['nickname'], 'string', 'max' => 50],
            [['gender'], 'string', 'max' => 5],
            [['province', 'city'], 'string', 'max' => 20],
            [['figureurl', 'figureurl_1', 'figureurl_2', 'figureurl_qq_1', 'figureurl_qq_2'], 'string', 'max' => 200],
            [['uid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'province' => 'Province',
            'city' => 'City',
            'year' => 'Year',
            'figureurl' => 'Figureurl',
            'figureurl_1' => 'Figureurl 1',
            'figureurl_2' => 'Figureurl 2',
            'figureurl_qq_1' => 'Figureurl Qq 1',
            'figureurl_qq_2' => 'Figureurl Qq 2',
        ];
    }
    
    /**
     * 统一获取头像
     */
    public function getDisplayAvatar()
    {
        //figureurl_qq_2不一定有，figureurl_qq_1一定有
        return empty($this->figureurl_qq_2)?$this->figureurl_qq_1:$this->figureurl_qq_2;
    }
    
    /**
     * 统一获取昵称
     */
    public function getDisplayName()
    {
        return $this->nickname;
    }

    /**
     * @inheritdoc
     * @return QqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QqQuery(get_called_class());
    }
}
