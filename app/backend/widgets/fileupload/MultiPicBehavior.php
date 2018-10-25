<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MultiPicBehavior extends \yii\base\Behavior
{
    
    public $picsAttribute = 'picarr';
    
    private $_pics;//json值
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeSaveMultiPic',
            
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveMultiPic',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveMultiPic',
        ];
    }
    
    public function getPics()
    {
        if($this->owner->isNewRecord || empty($this->owner->{$this->picsAttribute})) {
            return [];
        } else {
            //确保数据是新鲜的
            $modelClass = get_class($this->owner);
            $key = $this->owner->primaryKey()[0];
            $model = $modelClass::findOne($this->owner->{$key});
            $result = Json::decode($model->{$this->picsAttribute});
            return is_array($result)?$result:[];//以防转化json失败的情况
        }
    }
    
    //将原来的json值临时存储起来
    public function beforeSaveMultiPic()
    {
        $value = $this->owner->{$this->picsAttribute};
        //是数组则为新上传的内容，否则
        $this->_pics = is_array($value)?$value:[];
        $this->owner->{$this->picsAttribute} = null;
    }

    public function afterSaveMultiPic()
    {
        $modelClass = get_class($this->owner);
        $key = $this->owner->primaryKey()[0];
        if($this->_pics) {
            $json = Json::encode($this->_pics);
        } else {
            $json = '';
        }
        $modelClass::updateAll([$this->picsAttribute => $json], [$key => $this->owner->{$key}]);
    }
}