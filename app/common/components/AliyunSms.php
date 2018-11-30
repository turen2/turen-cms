<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\components;

//ini_set("display_errors", "on");

require_once __DIR__ . '/dysms/api_sdk/vendor/autoload.php';

use yii\base\Component;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();

/**
 * 这是短信服务API产品的DEMO程序，直接执行此文件即可体验短信服务产品API功能
 * (只需要将AK替换成开通了云通信-短信服务产品功能的AK即可)
 * 备注:Demo工程编码采用UTF-8
 */
class AliyunSms extends Component
{
    /**
     * @param string $accessKeyId 必填，AccessKeyId
     * @param string $accessKeySecret 必填，AccessKeySecret
     * // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
     */
    public $accessKeyId;
    public $accessKeySecret;
    
    private $_acsClient;
    private $_sendSmsRequest;
    private $_sendBatchSmsRequest;
    private static $acsClient;
    
    public function init()
    {
        parent::init();
        
        $this->_sendSmsRequest = new SendSmsRequest();
        $this->_sendBatchSmsRequest = new SendBatchSmsRequest();
        
        $this->initAcsClient();//生成static::$acsClient
    }

    /**
     * 取得AcsClient
     * @return DefaultAcsClient
     */
    public function initAcsClient() {
        //产品名称:云通信短信服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(empty(static::$acsClient)) {
            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $this->accessKeyId, $this->accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
    }

    /**
     * 发送短信
     * @param int $number 手机号码
     * @param string $sign 签名
     * @param string $tcode 模板CODE
     * @param array $meses 模板参数与之对应的内容
     * @param string $outId 可选流水号
     * @param string $extCode 拓展编号，自定义内容
     * @return stdClass 
     * 实例：
     * Yii::$app->sms->sendSms('13725514524', '豹品淘', 'SMS_91980004', ['code' => '1234']);
     */
    public function sendSms($number, $sign, $tcode, array $meses, $outId = null, $extCode = null) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = $this->_sendSmsRequest;

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($number);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($sign);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($tcode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        // 短信模板中字段的值
        $request->setTemplateParam(json_encode($meses, JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        if(!empty($outId)) {
            $request->setOutId($outId);
        }

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        if(!empty($extCode)) {
            $request->setSmsUpExtendCode($extCode);
        }
        
        // 发起访问请求
        $acsResponse = static::$acsClient->getAcsResponse($request);

        return $acsResponse;
    }

    /**
     * 批量发送短信
     * @param array $numbers 
     * @param array $signs 
     * @param string $tcode 
     * @param array $meses 
     * @return stdClass 
     * 实例：
     * Yii::$app->sms->sendBatchSms(['13725514524', '18589080024'], ['豹品淘', '豹品淘'], [['code' => '1234'], ['code' => '4321']], 'SMS_91980004');
     */
    public function sendBatchSms(array $numbers, array $signs, array $meses, $tcode) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = $this->_sendBatchSmsRequest;

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        //is_array($numbers) 必须为数组
        $request->setPhoneNumberJson(json_encode($numbers, JSON_UNESCAPED_UNICODE));

        // 必填:短信签名-支持不同的号码发送不同的短信签名
        $request->setSignNameJson(json_encode($signs, JSON_UNESCAPED_UNICODE));

        // 必填:短信模板-可在短信控制台中找到
        $request->setTemplateCode($tcode);

        // 必填:模板中的变量替换JSON串,如模板内容为"亲爱的${name},您的验证码为${code}"时,此处的值为
        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParamJson(json_encode($meses, JSON_UNESCAPED_UNICODE));

        // 可选-上行短信扩展码(扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段)
        // $request->setSmsUpExtendCodeJson("[\"90997\",\"90998\"]");

        // 发起访问请求
        $acsResponse = static::$acsClient->getAcsResponse($request);

        return $acsResponse;
    }

    /**
     * 短信发送记录查询
     * @return stdClass
     */
    public function querySendDetails() {

        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，短信接收号码
        $request->setPhoneNumber("12345678901");

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate("20170718");

        // 必填，分页大小
        $request->setPageSize(10);

        // 必填，当前页码
        $request->setCurrentPage(1);

        // 选填，短信发送流水号
        $request->setBizId("yourBizId");

        // 发起访问请求
        $acsResponse = static::$acsClient->getAcsResponse($request);

        return $acsResponse;
    }
}