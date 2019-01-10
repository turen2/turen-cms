<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\components;

use yii\base\Component;
use OSS\OssClient;
use OSS\Core\OssException;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\base\InvalidArgumentException;

//只实现对指定bucket的文件：上传、读取、（删除）

class AliyunOss extends Component
{
    //存储文件名
    const OSS_DEFAULT = 'cms-images';//默认路径
    
    //样式风格
    const OSS_STYLE_NAME180 = 'thumbnail';//缩略图固定名称，宽180
    
    //构造函数有几种情况： 
    //1. 一般的时候初始化使用 $ossClient = new OssClient($id, $key, $endpoint) 
    //2. 如果使用CNAME的，比如使用的是www.testoss.com，在控制台上做了CNAME的绑定，初始化使用 $ossClient = new OssClient($id, $key, $endpoint, true) 
    //3. 如果使用了阿里云SecurityTokenService(STS)，获得了AccessKeyID, AccessKeySecret, Token 初始化使用 $ossClient = new OssClient($id, $key, $endpoint, false, $token) 
    //4. 如果用户使用的endpoint是ip 初始化使用 $ossClient = new OssClient($id, $key, “1.2.3.4:8900”)
    
    public $isCName = false;//是否对Bucket做了域名绑定，并且Endpoint参数填写的是自己的域名
    
    public $endpoint = '';//您选定的OSS数据管理中心访问域名，例如oss-cn-hangzhou.aliyuncs.com
    
    public $useHttps = false;//是否启用https
    
    public $customDomain = '';//自定义域名
    
    public $bucket = '';//一个项目指定一个即可（比较固定）
    
    public $accessKeyId = '';//从OSS获得的AccessKeyId
    
    public $accessKeySecret = '';//从OSS获得的AccessKeySecret
    
    private $_ossClient;
    
    public function init()
    {
        parent::init();
        
        //校验参数
        if(empty($this->accessKeyId) || empty($this->accessKeySecret) || empty($this->endpoint)) {
            throw new InvalidArgumentException('阿里云OSS参数未配置，本项目依赖OSS存储资料文件。');
        }
        
        try {
            $this->_ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint, $this->isCName);
        } catch (OssException $e) {
            throw new HttpException($e->getMessage());
        }
        
        //设置超时
        $this->_ossClient->setTimeout(3600); /* seconds */
        $this->_ossClient->setConnectTimeout(10); /* seconds */
    }
    
    protected function addTestToName($object)
    {
        //方便清理测试数据，在oss的windows客户端批量清理！
        return YII_ENV_DEV?(substr($object, 0, strrpos($object, '/') + 1).'testtest'.basename($object)):$object;
    }
    
    /*
     public function createBucket($bucket)
     {
         try {
             $this->_ossClient->createBucket($bucket);
         } catch (OssException $e) {
             return;
         }
     }
     */
    
    /**
     * //上传文件到OSS
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function putFile($content, $object)
    {
        //$object = $this->addTestToName($object);//生成测试环境名
        try {
            $this->_ossClient->putObject($this->bucket, $object, $content);//无返回
        } catch (OssException $e) {
            throw new HttpException($e->getMessage());
        }
        return true;
    }
    
    /**
     * @return string
     */
    public function getFullPath()
    {
        return ($this->useHttps?'https://':'http://').
        (empty($this->customDomain)?($this->bucket.'.'.$this->endpoint):$this->customDomain).
        '/';
    }
    
    /**
     * 获取文件远程url地址
     * @param string $folder
     * @param string $time
     * @param string $md5
     * @param string $ext
     * @param string $thumb
     * @return string
     */
    public function getObjectUrl($object, $hasHttp = true, $thumb = '')
    {
        $basePath = $this->getFullPath();
        $img = $object;
        $hasHttp?($img = $basePath.$object):'';
        $thumb?($img .='?x-oss-process=style/'.$thumb):'';
        
        return $img;
    }

    /**
     * 远程获取资源对象参数
     * @param $object
     * @param bool $hasHttp
     * @return array|mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getObjectInfo($object, $hasHttp = true)
    {
        $basePath = $this->getFullPath();
        $imgRequest = $object;
        $hasHttp?($imgRequest = $basePath.$object):'';
        //$imgRequest .='?x-oss-process=image/info';//请求规则

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl($imgRequest)
            ->setData(['x-oss-process' => 'image/info'])
            ->send();
        if ($response->isOk) {
            return Json::decode($response->content);
        } else {
            return [];
        }
    }
    
    /**
     * 获取文件类内容
     * @param string $object
     * @throws HttpException
     * @return string
     */
    public function getFileContent($object = '')
    {
        $content = '';
        try {
            $content = $this->_ossClient->getObject($this->bucket, $object);
        } catch (OssException $e) {
            throw new HttpException($e->getMessage());
        }
        return $content;
    }
    
    //枚举文件(包含颁)
    /*
     array $options 其中options中的参数如下
     $options = array(
     'max-keys' => max-keys用于限定此次返回object的最大数，如果不设定，默认为100，max-keys取值不能大于1000。
     'prefix' => 限定返回的object key必须以prefix作为前缀。注意使用prefix查询时，返回的key中仍会包含prefix。
     'delimiter' => 是一个用于对Object名字进行分组的字符。所有名字包含指定的前缀且第一次出现delimiter字符之间的object作为一组元素
     'marker' => 用户设定结果从marker之后按字母排序的第一个开始返回。 ) 其中 prefix，marker用来实现分页显示效果，参数的长度必须小于256字节。
     */
    public function getFiles($options = [], &$objectList = [])
    {
        try {
            $listObjectInfo = $this->_ossClient->listObjects($this->bucket, $options);
        } catch (OssException $e) {
            throw new HttpException($e->getMessage());
        }
        
        foreach ($listObjectInfo->getObjectList() as $object) {
            if($object->getSize() > 0) {
                $objectList[] = $object;
            }
        }
        
        foreach ($listObjectInfo->getPrefixList() as $prefix) {
            $options['prefix'] = $prefix->getPrefix();
            $this->getFiles($options, $objectList);
        }
        
        // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
        $nextMarker = $listObjectInfo->getNextMarker();
        if ($nextMarker === '') {
            return $objectList;
        }
    }
}