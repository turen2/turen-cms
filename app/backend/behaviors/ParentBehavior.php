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

class ParentBehavior extends \yii\base\Behavior
{
    public $parentPrimaryField = 'id';
    public $parentidField = 'parentid';
    public $parentidStrField = 'parentstr';
    public $parentClassName = null;

    public $foreignField = null;
    public $pidField = 'parentid';
    public $pStrField = 'parentstr';

    public function init()
    {
        if(empty($this->parentPrimaryField)
            || empty($this->parentidField)
            || empty($this->parentidStrField)
            || empty($this->foreignField)
            || empty($this->pidField)
            || empty($this->pStrField)
            || empty($this->parentClassName)) {
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
        if(!empty($model->{$this->foreignField})) {
            $className = $this->parentClassName;
            $parentModel = $className::findOne([$this->parentPrimaryField => $model->{$this->foreignField}]);
            if($parentModel) {
                $model->{$this->pidField} = $parentModel->{$this->parentidField};
                $model->{$this->pStrField} = $parentModel->{$this->parentidStrField};
            }
        }
    }
}