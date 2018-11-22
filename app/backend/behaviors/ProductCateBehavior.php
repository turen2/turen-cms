<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\InvalidArgumentException;
use app\models\shop\ProductCate;

class ProductCateBehavior extends \yii\base\Behavior
{
    public $pcateidField = 'pcateid';
    public $pcatepidField = 'pcatepid';
    public $pcatepstrField = 'pcatepstr';
    
    public function init()
    {
        if(empty($this->pcateidField) || empty($this->pcatepidField) || empty($this->pcatepstrField)) {
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
        if(!empty($model->{$this->pcateidField})) {
            $productCateModel = ProductCate::findOne(['id' => $model->{$this->pcateidField}]);
            if($productCateModel) {
                $model->{$this->pcatepidField} = $productCateModel->parentid;
                $model->{$this->pcatepstrField} = $productCateModel->parentstr;
            }
        }
    }
}