<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\actions;

//通用报表下载器，以用户的身份且有下载权限自己下载自己的报表

use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

use app\models\tools\Report;
use app\components\phpoffice\DataExport;

class DownLoaderAction extends Action
{
    public $id;
    
    private $_model;
    
    private $_identity;
    
    public function init()
    {
        parent::init();
        
        $this->_identity = Yii::$app->user->getIdentity();
        $this->_model = Report::findOne(['id' => $this->id]);
        if(empty($this->_model)) {
            throw new NotFoundHttpException(Yii::t('common', 'Not Found The File.'));
        }
    }
    
    public function run()
    {
        if($this->isActive()) {
            //下载
            $storagePath = Yii::getAlias(DataExport::REPORT_PATH);
            
            $fileName = $this->_model->name;
            
            $file = $storagePath.$this->_model->user_id.'/'.date('Y_m_d', $this->_model->created_at).'/'.$fileName;
            
            if (!is_file($file)) {
                throw new NotFoundHttpException(Yii::t('common', 'The file does not exists.'));
            }
            
            return Yii::$app->response->sendFile($file, $fileName);
        }
    }
    
    public function beforeRun()
    {
        //记录下载次数
        $this->_model->updateCounters(['count' => 1]);//+1
        //更新最后下载时间
        $this->_model->touch('last_down_at');
        
        return true;
    }
    
    //相关验证
    protected function isActive()
    {
        if($this->_identity->id != $this->_model->user_id) {
            //没有权限
            throw new ForbiddenHttpException(Yii::t('common', 'The file not belong current user.'));
        }
        
        return true;
    }
}