<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\components\AliyunOss;
use yii\base\Exception;
use yii\base\InvalidConfigException;

class FileUploadAction extends Action
{
    public $uploadName = 'file';//接收上传的字段
    public $folder;//上传到的目录，AliyunOss中有规定
    
    public function init()
    {
        parent::init();
        
        //open csrf
        Yii::$app->getRequest()->enableCsrfValidation = true;
        
        if(empty($this->folder)) {
            throw new InvalidConfigException('上传组件配置错误。');
        }
    }

    /**
     * 执行并处理action
     */
    public function run()
    {
        $uploadedFile = UploadedFile::getInstanceByName($this->uploadName);
        $content = file_get_contents($uploadedFile->tempName);
        $md5 = md5($content.$this->folder);//内容+文件夹+日期=文件名，即同一文件，同一次上传不允许重复
        $time = time();
        //文件的长和宽
        list($width, $height) = getimagesize($uploadedFile->tempName);
        
        $object = $this->folder.
            '/'.date('Y_m_d', $time).
            '/'.$md5 . '=='.$width.'x'.$height .'.'. $uploadedFile->extension;
        try {
            //上传是开放oss
            Yii::$app->aliyunoss->putFile($content, $object);//return boolean
        } catch (Exception $e) {//HttpException
            return Json::encode(['state' => false, 'msg' => $e->getMessage().'请联系开发者qq:980522557']);
        }
        
        $basePath = Yii::$app->aliyunoss->getFullPath();
        $msg = [
            'name' => $uploadedFile->name,//中文名
            'size' => $uploadedFile->size,//bit
            'type' => $uploadedFile->type,
            
            'url' => Yii::$app->aliyunoss->getObjectUrl($object),
            'thumbnailUrl' => Yii::$app->aliyunoss->getObjectUrl($object, true, AliyunOss::OSS_STYLE_NAME180),
            'objectUrl' => Yii::$app->aliyunoss->getObjectUrl($object, false),//提交到字段的object地址
        ];
        
        return Json::encode(['state' => true, 'msg' => $msg]);
    }
}