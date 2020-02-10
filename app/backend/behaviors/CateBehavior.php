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
use backend\models\cms\Cate;

class CateBehavior extends \yii\base\Behavior
{
    public $cateIdField = 'cateid';
    public $catePidField = 'catepid';
    public $catepStrField = 'catepstr';
    
    public function init()
    {
        if(empty($this->cateIdField) || empty($this->catePidField) || empty($this->catepStrField)) {
            throw new InvalidArgumentException(self::class.'参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateCate',
        ];
    }
    
    public function beforeValidateCate()
    {
        $model = $this->owner;
        if(!empty($model->{$this->cateIdField})) {
            $cateModel = Cate::findOne(['id' => $model->{$this->cateIdField}]);
            if($cateModel) {
                $model->{$this->catePidField} = $cateModel->parentid;
                $model->{$this->catepStrField} = $cateModel->parentstr;
            }
        }
    }
}