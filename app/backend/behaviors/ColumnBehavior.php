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
use app\models\cms\Column;

class ColumnBehavior extends \yii\base\Behavior
{
    public $columnIdField = 'columnid';
    public $parentIdField = 'parentid';
    public $parentStrField = 'parentstr';
    
    public function init()
    {
        if(empty($this->columnIdField) || empty($this->parentIdField) || empty($this->parentStrField)) {
            throw new InvalidArgumentException(self::class.'参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateColumn',
        ];
    }
    
    public function beforeValidateColumn()
    {
        $model = $this->owner;
        if(!empty($model->{$this->columnIdField})) {
            $columModel = Column::findOne(['id' => $model->{$this->columnIdField}]);
            if($columModel) {
                $model->{$this->parentIdField} = $columModel->parentid;
                $model->{$this->parentStrField} = $columModel->parentstr;
            }
        }
    }
}