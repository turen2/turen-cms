<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use common\models\user\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\helpers\Util;
use console\queue\AlismsJob;
use console\queue\SmtpMailJob;
use yii\helpers\StringHelper;
use common\helpers\Functions;

/**
 * This is the model class for table "{{%user_inquiry}}".
 *
 * @property string $ui_id 留言id
 * @property string $ui_service_num 服务单号
 * @property string $ui_title 预约标题
 * @property string $ui_content 预约内容
 * @property string $user_id 关系用户
 * @property string $ui_ipaddress 来源地址
 * @property string $ui_browser 客户端信息
 * @property string $ui_remark 备注（给自己看的）
 * @property string $ui_submit_time 预约提交时间
 * @property string $ui_remark_time 备注时间
 */
class Inquiry extends \common\components\ActiveRecord
{
    public $keyword;

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
            [['ui_title', 'ui_content', 'ui_ipaddress', 'ui_browser', 'ui_remark'], 'required'],
            [['user_id', 'ui_submit_time', 'ui_remark_time'], 'integer'],
            [['ui_browser', 'ui_remark', 'ui_service_num'], 'string'],
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
            'ui_content' => '预约内容',
            'user_id' => '用户',
            'ui_ipaddress' => '来源',
            'ui_browser' => '客户端',
            'ui_remark' => '备忘录',
            'ui_submit_time' => '提交时间',
            'ui_remark_time' => '备忘时间',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    /**
     * 创建预约服务单
     * @param $data
     * @param bool $sendQueue
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public static function CreateInquiryOrder($data, $sendQueue = true)
    {
        $service = $data['service'];
        $name = $data['name'];
        $phone = $data['phone'];

        $address = Util::IPAddess();
        //array(3) { ["service"]=> string(12) "外墙粉刷" ["name"]=> string(9) "夏先生" ["phone"]=> string(11) "13725514524" }

        Yii::$app->getDb()->createCommand()->insert(self::tableName(), [
            'ui_title' => '快捷预约 '.date('Y-m-d'),
            'ui_content' => Json::encode($data),
            'user_id' => Yii::$app->getUser()->getId(),
            'ui_ipaddress' => is_null($address['location'])?'':$address['location'],
            'ui_browser' => Yii::$app->getRequest()->userAgent,
            'ui_submit_time' => time(),
        ])->execute();

        //生成订单号
        $lastInsertId = Yii::$app->getDb()->lastInsertID;
        Yii::$app->getDb()->createCommand()->update(self::tableName(), [
            'ui_service_num' => Util::GenerateSimpleOrderNumber('FU', $lastInsertId),
        ], ['ui_id' => $lastInsertId])->execute();

        // 给用户回复一条确认短信
        $signTemplate = Yii::$app->params['call_success_tips'];
        Yii::$app->smsQueue->push(new AlismsJob([
            'phoneNumber' => $phone,
            'signName' => $signTemplate['signName'],
            'templateCode' => $signTemplate['templateCode'],
            'templateParams' => [
                'name' => $name,
                'event' => $service,
            ],
        ]));

        //邮件通知队列
        if($sendQueue) {
            foreach (explode("\r\n", Yii::$app->params['config_email_notify_online_call_price']) as $sendTo) {
                $sendTo = trim($sendTo);
                if(!empty($sendTo)) {
                    //设置重试间隔时间、延迟时间、优先级。
//                    Yii::$app->mailQueue->ttr(10);
//                    Yii::$app->mailQueue->delay(0);
//                    Yii::$app->mailQueue->priority(100);
                    
                    Yii::$app->mailQueue->push(new SmtpMailJob([
                        'template' => GLOBAL_LANG.'/notify',//语言标识模板名称
                        'params' => [
                            '业务类型' => $service,
                            '称呼' => $name,
                            '电话' => $phone,
                        ],
                        'sendTo' => $sendTo,
                        'from' => [Yii::$app->params['config.supportEmail'] => Yii::$app->params['config_site_name']],
                        'subject' => '有新的预约 -- ' . Yii::$app->params['config_site_name'],
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
//                        Yii::$app->smsQueue->ttr(10);
//                        Yii::$app->smsQueue->delay(0);
//                        Yii::$app->smsQueue->priority(99);

                    Yii::$app->smsQueue->push(new AlismsJob([
                        'phoneNumber' => $sendTo,
                        'signName' => $signTemplate['signName'],
                        'templateCode' => $signTemplate['templateCode'],
                        'templateParams' => [
                            'name' => $name,
                            'phone' => $phone,
                            'event' => $service,
                        ],
                    ]));
                }
            }
        }
    }

    public static function CallPriceUserList()
    {
        $list = Util::VirtualUserList(10);

        // 今天，开始时间
        $todayTime = strtotime(date('Y-m-d'));
        $inquiries = static::find()->where(['>', 'ui_submit_time', $todayTime])->orderBy(['ui_submit_time' => SORT_DESC])->asArray()->all();
        $realList = [];
        foreach ($inquiries as $inquirie) {
            $content = Json::decode($inquirie['ui_content']);
            if(!empty($content) && isset($content['phone']) && isset($content['name'])) {
                $realList[$content['phone']] = Functions::toTime($inquirie['ui_submit_time']).' '.$content['name'].' ****'.StringHelper::byteSubstr($content['phone'], 7, 4).'已预约';
            }
        }

        $list = ArrayHelper::merge($list, $realList);
        krsort($list);

        return $list;
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
