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
use backend\models\cms\Flag;

class FlagBehavior extends \yii\base\Behavior
{
    public $flagField = 'flag';
    
    public function init()
    {
        if(empty($this->flagField)) {
            throw new InvalidArgumentException('FlagBehavior::$flagField参数未配置');
        }
    }
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateFlag',
        ];
    }
    
    public function beforeValidateFlag()
    {
        $model = $this->owner;
        if(empty($model->{$this->flagField})) {
            $model->{$this->flagField} = '';
        }
        //转化flag为字符串
        if(is_array($model->{$this->flagField})) {
            $model->{$this->flagField} = implode(',', $model->{$this->flagField});
        }
    }
    
    /**
     * 获取当前对象选中的标签列表
     * @param integer $columnId 栏目id
     * @param string $haveFlag 标签名是否带[flag]
     * @return \backend\behaviors\string[]
     */
    public function activeFlagList($columnId, $haveFlag = false)
    {
        $model = $this->owner;
        $flagList = Flag::ColumnFlagList($columnId, $haveFlag);
        $activeFlagList = [];
        if(!empty($model->{$this->flagField})) {
            $flags = is_array($model->{$this->flagField})?$model->{$this->flagField}:explode(',', $model->{$this->flagField});
            foreach ($flags as $flag) {
                if(isset($flagList[$flag])) {
                    $activeFlagList[$flag] = $flagList[$flag];
                }
            }
        }
        
        return $activeFlagList;
    }
}