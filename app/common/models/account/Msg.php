<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use Yii;
use yii\base\InvalidArgumentException;
use yii\behaviors\TimestampBehavior;
use common\behaviors\InsertLangBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%user_msg}}".
 *
 * @property string $msg_id ID
 * @property string $msg_content 消息内容，以json格式存储
 * @property int $msg_type 消息类型，1反馈通知，2优惠促销，3服务消息
 * @property string $msg_user_id 用户id
 * @property int $msg_readtime 是否已读
 * @property int $msg_deltime 删除时间
 * @property string $lang 多语言
 * @property string $orderid 排序
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Msg extends \common\components\ActiveRecord
{
    //1反馈通知，2优惠促销，3服务消息
    const MSG_TYPE_FEEDBACK = 1;
    const MSG_TYPE_DISCOUNT = 2;
    const MSG_TYPE_SERVICE = 3;

    public function behaviors()
    {
        return [
            'timemap' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
            'insertlang' => [//自动填充多站点和多语言
                'class' => InsertLangBehavior::class,
                'insertLangAttribute' => 'lang',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_msg}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['msg_type', 'msg_user_id', 'orderid', 'msg_readtime', 'msg_deltime', 'created_at', 'updated_at'], 'integer'],
            [['msg_content'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => 'ID',
            'msg_content' => '消息内容',
            'msg_type' => '消息类型',
            'msg_user_id' => '用户',
            'msg_readtime' => '查看情况',
            'msg_deltime' => '删除时间',
            'lang' => '多语言',
            'orderid' => '排序',
            'created_at' => '发布时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取消息类型列表
     * @return array
     */
    public static function TypeList()
    {
        return [
            static::MSG_TYPE_FEEDBACK => '反馈通知',
            static::MSG_TYPE_DISCOUNT => '优惠促销',
            static::MSG_TYPE_SERVICE => '服务消息',
        ];
    }

    /**
     * 获取类型名称
     * @param $type
     * @return mixed|string
     */
    public static function TypeName($type)
    {
        $typeList = self::TypeList();
        return isset($typeList[$type])?$typeList[$type]:'其它类型';
    }

    /**
     * 多种类型的消息，获得统一的标题展示
     * @param string $content
     * @return mixed
     */
    public static function MsgTitle(string $content)
    {
        $content = Json::decode($content);
        if(isset($content['question'])) {
            return $content['question'];
        } else {
            return $content['content'];
        }
    }

    /**
     * 发送一条消息，全局唯一消息发送入口！！！
     *
     * 如果消息类型为MSG_TYPE_FEEDBACK，则$content的数组元素为：question和answer
     * 如果消息的类型为其它，则$content的数组元素为：content
     *
     * @param $type
     * @param array $content
     * @param $userId
     * @param $lang
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function SendMsg($type ,array $content, $userId, $lang)
    {
        if($type == static::MSG_TYPE_FEEDBACK && (!isset($content['question']) || !isset($content['answer']))) {
            throw new InvalidArgumentException('消息实体与类型格式不匹配~');
        }
        if($type != static::MSG_TYPE_FEEDBACK && !isset($content['content'])) {
            throw new InvalidArgumentException('消息实体与类型格式不匹配');
        }

        Yii::$app->getDb()->createCommand()->insert(Msg::tableName(), [
            'msg_content' => Json::encode($content),
            'msg_type' => $type,
            'msg_user_id' => $userId,
            'msg_readtime' => 0,
            'msg_deltime' => 0,
            'lang' => $lang,
            'orderid' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ])->execute();

        return true;
    }

    /**
     * {@inheritdoc}
     * @return MsgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MsgQuery(get_called_class());
    }
}
