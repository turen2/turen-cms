<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\base\InvalidArgumentException;

class AttributeJsonBehavior extends \yii\base\Behavior
{
    
    public $jsonAttribute;
    
    private $_jsonAttribute;//json值
    
    public function init()
    {
        if(empty($this->jsonAttribute)) {
            throw new InvalidArgumentException('jsonAttribute参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeSaveJson',
            
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveJson',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveJson',
        ];
    }
    
    public function getAttributeToArray()
    {
        if($this->owner->isNewRecord || empty($this->owner->{$this->jsonAttribute})) {
            return [];
        } else {
            //确保数据是新鲜的
            $modelClass = get_class($this->owner);
            $key = $this->owner->primaryKey()[0];
            $model = $modelClass::findOne($this->owner->{$key});
            return Json::decode($model->{$this->jsonAttribute});
        }
    }
    
    //将原来的json值临时存储起来
    public function beforeSaveJson()
    {
        $value = $this->owner->{$this->jsonAttribute};
        //是数组则为新上传的内容，否则
        $this->_jsonAttribute = is_array($value)?$value:[];
        $this->owner->{$this->jsonAttribute} = '';
    }

    public function afterSaveJson()
    {
        $modelClass = get_class($this->owner);
        $key = $this->owner->primaryKey()[0];
        if($this->_jsonAttribute) {
            $json = Json::encode($this->_jsonAttribute);
        } else {
            $json = '';
        }
        
        $modelClass::updateAll([$this->jsonAttribute => $json], [$key => $this->owner->{$key}]);
    }
}