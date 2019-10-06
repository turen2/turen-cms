<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use Yii;
use yii\helpers\Json;
use common\helpers\Util;
use common\models\shop\Product;
use console\queue\AlismsJob;
use console\queue\SmtpMailJob;

/**
 * This is the model class for table "{{%user_inquiry}}".
 *
 * @property string $ui_id 留言id
 * @property string $ui_service_num 服务单号
 * @property string $ui_title 预约标题
 * @property string $ui_picurl 服务主图
 * @property string $ui_content 预约内容
 * @property int $ui_product_id 关联服务产品id
 * @property string $user_id 关系用户
 * @property string $ui_ipaddress 来源地址
 * @property string $ui_browser 客户端信息
 * @property string $ui_answer 回应
 * @property string $ui_remark 备注（给自己看的）
 * @property int $ui_type 类型：1首页预约，2价格计算器预约，3业务详情预约
 * @property int $ui_state 处理状态：0未处理，1待处理，2已处理
 * @property string $ui_submit_time 预约提交时间
 * @property string $ui_answer_time 回应时间
 * @property string $ui_remark_time 备注时间
 */
class Inquiry extends \common\components\ActiveRecord
{
    public $keyword;

    //ui_type类型：1首页预约，2价格计算器预约，3业务详情预约
    const INQUIRY_TYPE_QUICK = 1;//快捷预约
    const INQUIRY_TYPE_JIJIA = 2;//计算器预约
    const INQUIRY_TYPE_SERVICE = 3;//业务详情预约

    //ui_state处理状态：1未处理，2待处理，3已处理
    const INQUIRY_STATE_NOTHING = 1;
    const INQUIRY_STATE_WAITING = 2;
    const INQUIRY_STATE_OK = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_inquiry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ui_title', 'ui_content', 'ui_ipaddress', 'ui_browser', 'ui_answer', 'ui_remark'], 'required'],
            [['user_id', 'ui_type', 'ui_state', 'ui_submit_time', 'ui_answer_time', 'ui_remark_time', 'ui_product_id'], 'integer'],
            [['ui_browser', 'ui_answer', 'ui_remark', 'ui_service_num', 'ui_picurl'], 'string'],
            [['ui_title'], 'string', 'max' => 30],
            [['ui_content'], 'string', 'max' => 50],
            [['ui_ipaddress'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ui_id' => 'id',
            'ui_service_num' => '服务单号',
            'ui_title' => '预约标题',
            'ui_picurl' => '服务主图',
            'ui_content' => '预约内容',
            'ui_product_id' => '关联服务产品id',
            'user_id' => '用户',
            'ui_ipaddress' => '来源',
            'ui_browser' => '客户端',
            'ui_answer' => '回复',
            'ui_remark' => '备忘录',
            'ui_type' => '预约类型',
            'ui_state' => '处理状态',
            'ui_submit_time' => '提交时间',
            'ui_answer_time' => '回复时间',
            'ui_remark_time' => '备忘时间',
        ];
    }

    public static function getStateNameList()
    {
        return [
            static::INQUIRY_STATE_NOTHING => '未处理',
            static::INQUIRY_STATE_WAITING => '待处理',
            static::INQUIRY_STATE_OK => '已处理',
        ];
    }

    /**
     * 返回预约状态名称
     * @return string
     */
    public function getStateName()
    {
        $list = static::getStateNameList();
        return isset($list[$this->ui_state])?$list[$this->ui_state]:'未设置';
    }

    public static function getTypeNameList()
    {
        return [
            static::INQUIRY_TYPE_QUICK => '快捷预约',
            static::INQUIRY_TYPE_JIJIA => '计算器预约',
            static::INQUIRY_TYPE_SERVICE => '业务详情预约',
        ];
    }

    /**
     * 预约类型名称
     * @return string
     */
    public function getTypeName()
    {
        $list = static::getTypeNameList();
        return isset($list[$this->ui_type])?$list[$this->ui_type]:'未设置';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    /**
     * 创建预约服务单
     * @param $data
     * @param bool $sendQueue
     * @return void
     */
    public static function CreateInquiryOrder($data, $type, $sendQueue = true)
    {
        $address = Util::IPAddess();

        if($type == self::INQUIRY_TYPE_QUICK) {//快捷服务单
            $area = $data['area'];
            $phone = $data['phone'];
            $productId = $data['productId'];
            $type = '快捷预约';

            $productModel = Product::findOne(['id' => $productId]);

            //录入到系统
            $content = Json::encode([
                '电话' => $phone,
                '位置' => $area,
                '业务类型' => $type,
            ]);

            Yii::$app->getDb()->createCommand()->insert(self::tableName(), [
                'ui_title' => $productModel->title,
                'ui_picurl' => $productModel->picurl,
                'ui_content' => $content,
                'ui_product_id' => $productId,
                'user_id' => Yii::$app->getUser()->getId(),
                'ui_ipaddress' => $address['location'],
                'ui_browser' => Yii::$app->getRequest()->userAgent,
                'ui_type' => self::INQUIRY_TYPE_QUICK,//快捷预约
                'ui_state' => self::INQUIRY_STATE_NOTHING,//待处理
                'ui_submit_time' => time(),
            ])->execute();

            //生成订单号
            $lastInsertId = Yii::$app->getDb()->lastInsertID;
            Yii::$app->getDb()->createCommand()->update(self::tableName(), [
                'ui_service_num' => Util::GenerateSimpleOrderNumber('FU'.self::INQUIRY_TYPE_QUICK, $lastInsertId),
            ], ['ui_id' => $lastInsertId])->execute();

            //邮件通知队列
            if($sendQueue) {
                foreach (explode("\r\n", Yii::$app->params['config_email_notify_online_call_price']) as $sendTo) {
                    $sendTo = trim($sendTo);
                    if(!empty($sendTo)) {
                        //设置重试间隔时间、延迟时间、优先级。
                        Yii::$app->mailQueue->ttr(10);
                        Yii::$app->mailQueue->delay(0);
                        Yii::$app->mailQueue->priority(100);

                        Yii::$app->mailQueue->push(new SmtpMailJob([
                            'template' => GLOBAL_LANG.'/notify',//语言标识模板名称
                            'params' => [
                                '电话' => $phone,
                                '位置' => $area,
                                '业务类型' => $type,
                            ],
                            'sendTo' => $sendTo,
                            'from' => [Yii::$app->params['config.supportEmail'] => Yii::$app->params['config_site_name']],
                            'subject' => '有新的快捷预约 -- ' . Yii::$app->params['config_site_name'],
                        ]));
                    }
                }

                //短信通知队列
                //有新预约订单了，用户：${name}，地址：${address}，电话：${phone}，业务：${event}，请及时处理以免造成损失。
                $signTemplate = Yii::$app->params['call_price_notify'];
                foreach (explode("\r\n", Yii::$app->params['config_sms_notify_online_call_price']) as $sendTo) {
                    $sendTo = trim($sendTo);
                    if(!empty($sendTo)) {
                        //设置重试间隔时间、延迟时间、优先级。
                        Yii::$app->smsQueue->ttr(10);
                        Yii::$app->smsQueue->delay(0);
                        Yii::$app->smsQueue->priority(99);

                        Yii::$app->smsQueue->push(new AlismsJob([
                            'phoneNumber' => $sendTo,
                            'signName' => $signTemplate['signName'],
                            'templateCode' => $signTemplate['templateCode'],
                            'templateParams' => [
                                'name' => Yii::$app->getUser()->isGuest?'未知':Yii::$app->getUser()->getIdentity()->username,
                                'address' => $area,
                                'phone' => $phone,
                                'event' => $type,
                            ],
                        ]));
                    }
                }
            }
        } elseif($type == self::INQUIRY_TYPE_JIJIA) {//计算器预约

        } elseif($type == self::INQUIRY_TYPE_SERVICE) {//服务详情预约

        }
    }

    /**
     * {@inheritdoc}
     * @return InquiryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InquiryQuery(get_called_class());
    }
}
