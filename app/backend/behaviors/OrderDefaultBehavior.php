<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\InvalidArgumentException;
use backend\helpers\BackCommonHelper;

class OrderDefaultBehavior extends \yii\base\Behavior
{
    public $orderidField = 'orderid';
    
    public function init()
    {
        if(empty($this->orderidField)) {
            throw new InvalidArgumentException(self::class.'参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateOrderId',
        ];
    }
    
    public function beforeValidateOrderId()
    {
        $model = $this->owner;
        if(empty($model->{$this->orderidField})) {
            $className = get_class($model);
            //$primayKey = $className::primaryKey()[0];
            $query = $className::find();
            if(BackCommonHelper::CheckFieldExist($className, 'lang')) {
                $query = $query->current();
            }
            $maxModel = $query->orderBy([$this->orderidField => SORT_DESC])->one();
            if($maxModel) {
                $value = $maxModel->{$this->orderidField} + 1;
                //var_dump($value);exit;
            } else {
                $value = Yii::$app->params['config.orderid'];//配置默认值
            }
            
            $model->{$this->orderidField} = $value;
        }
    }
}