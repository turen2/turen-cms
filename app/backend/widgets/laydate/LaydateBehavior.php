<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\laydate;

use Yii;
use yii\db\ActiveRecord;

class LaydateBehavior extends \yii\base\Behavior
{
    
    public $timeAttribute = 'posttime';
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateDateTime',
        ];
    }
    
    /**
     * 验证之前统一转化为时间戳
     * @return number
     */
    public function beforeValidateDateTime()
    {
        $model = $this->owner;
        $attribute = $this->timeAttribute;
        $time = time();
        if(!empty($model->{$attribute})) {
            if(strcmp($model->{$attribute}, intval($model->{$attribute})) == 0) {
                $time = $model->{$attribute};
            } else if(strpos($model->{$attribute}, '-') !== false) {
                $time = strtotime($model->{$attribute});
            }
        }
        
        $model->{$attribute} = $time;
    }
    
    /**
     * 从数据库中或者提交不成功数据中获取正确的时间格式
     * @param string $attribute 用于一个区分表单中的多个时间控件
     * @return string
     */
    public function dateTimeValue($attribute = null)
    {
        $model = $this->owner;
        if(is_null($attribute)) { 
            $attribute = $this->timeAttribute;
        }
        
        if(!empty($model->{$attribute})) {
            if(strpos($model->{$attribute}, '-') !== false) {
                return $model->{$attribute};
            } elseif(strcmp($model->{$attribute}, intval($model->{$attribute})) == 0) {
                return date('Y-m-d', $model->{$attribute});
            }
        }
        
        return date('Y-m-d');
    }
    
    /**
     * 数据库中的真实值
     */
    protected function dbtime() {
        $attribute = $this->timeAttribute;
        $modelClass = get_class($this->owner);
        $key = $this->owner->primaryKey()[0];
        $model = $modelClass::findOne($model->{$key});
        return $model->{$attribute};
    }
}