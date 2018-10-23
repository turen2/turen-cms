<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\calendar;

use Yii;
use yii\db\ActiveRecord;

class DateTimeBehavior extends \yii\base\Behavior
{
    
    public $timeAttribute = 'posttime';
    
    private $_time;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSaveDateTime',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSaveDateTime',
            
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveDateTime',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveDateTime',
        ];
    }
    
    public function getStrTime()
    {
        if($this->owner->isNewRecord) {//new
            return date('Y-m-d H:i:s');
        } else {
            $modelClass = get_class($this->owner);
            $key = $this->owner->primaryKey()[0];
            
            $model = $modelClass::findOne($this->owner->{$key});
            return date('Y-m-d H:i:s', $model->{$this->timeAttribute});
        }
    }
    
    public function beforeSaveDateTime()
    {
        //将原来的str值临时存储起来
        $this->_time = $this->owner->{$this->timeAttribute};
        $this->_time = empty($this->_time)?date('Y-m-d H:i:s'):$this->_time;
        $this->owner->{$this->timeAttribute} = 0;//临时为0
    }

    public function afterSaveDateTime()
    {
        $modelClass = get_class($this->owner);
        $key = $this->owner->primaryKey()[0];
        $modelClass::updateAll([$this->timeAttribute => strtotime($this->_time)], [$key => $this->owner->{$key}]);
    }
}