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
use backend\models\site\HelpCate;

class HelpCateBehavior extends \yii\base\Behavior
{
    public $cateidField = 'cateid';
    public $catepidField = 'catepid';
    public $catepstrField = 'catepstr';
    
    public function init()
    {
        if(empty($this->cateidField) || empty($this->catepidField) || empty($this->catepstrField)) {
            throw new InvalidArgumentException(self::class.'参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateHelpCate',
        ];
    }
    
    public function beforeValidateHelpCate()
    {
        $model = $this->owner;
        if(!empty($model->{$this->cateidField})) {
            $helpCateModel = HelpCate::findOne(['id' => $model->{$this->cateidField}]);
            if($helpCateModel) {
                $model->{$this->catepidField} = $helpCateModel->parentid;
                $model->{$this->catepstrField} = $helpCateModel->parentstr;
            }
        }
    }
}