<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\diyfield;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\base\InvalidArgumentException;
use backend\models\cms\DiyField;
use backend\models\cms\Column;

class DiyFieldBehavior extends \yii\base\Behavior
{
    private static $_fieldModels;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateField',
            //ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveField',
            //ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveField',
        ];
    }
    
    /**
     * 验证之前，统一转化为非数组
     */
    public function beforeValidateField()
    {
        $model = $this->owner;
        
        if(is_null(self::$_fieldModels)) {//缓存处理
            //组织数据
            $id = Column::ColumnConvert('class2id', get_class($model));//所属模型
            self::$_fieldModels = DiyField::FieldModelList($id, $model->columnid);//取匹配的活动字段
        }
        
        if(self::$_fieldModels) {
            foreach (self::$_fieldModels as $fieldModel) {
                $attribute = DiyField::FIELD_PRE.$fieldModel->fd_name;
                switch ($fieldModel->fd_type) {
                    case 'varchar':
                    case 'int':
                    case 'decimal':
                    case 'text'://多文本
                    case 'mediumtext'://编辑器
                    case 'radio'://单选
                    case 'select'://下拉
                    case 'file'://单文件
                        //nothing
                        break;
                    case 'checkbox'://多选
                    case 'filearr'://多文件
                        $value = $model->{$attribute};
                        if(!empty($value)) {
                            if(is_array($value)) {
                                $value = Json::encode($value);
                            }
                        } else {
                            $value = '';
                        }
                        $model->{$attribute} = $value;
                        break;
                    case 'datetime'://日期
                        $time = time();
                        if(!empty($model->{$attribute})) {
                            if(strcmp($model->{$attribute}, intval($model->{$attribute})) == 0) {
                                $time = $model->{$attribute};
                            } else if(strpos($model->{$attribute}, '-') !== false) {
                                $time = strtotime($model->{$attribute});
                            }
                        }
                        $model->{$attribute} = $time;
                        break;
                    default:
                        break;
                }
            }
        }
    }
    
    /**
     * datetime时间类型处理
     * @param string $field 数据库字段或字段名
     * @return string
     */
    public function diyFieldDateTimeValue($field)
    {
        $model = $this->owner;
        $attribute = (strpos($field, DiyField::FIELD_PRE) === false)?DiyField::FIELD_PRE.$field:$field;
        
        if(isset($model->{$attribute})) {
            if(!empty($model->{$attribute})) {
                if(strpos($model->{$attribute}, '-') === false) {//是时间戳
                    return date('Y-m-d', $model->{$attribute});
                } else {//日期直接返回
                    return $model->{$attribute};
                }
            }
        }
        
        return date('Y-m-d');
    }
    
    /**
     * checkbox多选类型处理
     * @param string $field 数据库字段或字段名
     * @return array
     */
    public function diyFieldCheckboxValue($field)
    {
        $model = $this->owner;
        $attribute = (strpos($field, DiyField::FIELD_PRE) === false)?DiyField::FIELD_PRE.$field:$field;
        
        $value = $model->{$attribute};
        if(is_array($value)) {
            return $value;
        } else {
            try {
                $value = Json::decode($value);
            } catch (InvalidArgumentException $e) {//直接忽略跳过
                $value = [];
            }
            
            return is_array($value)?$value:[];//防止null和空的情况
        }
    }
    
    /**
     * 多图处理
     * @param string $field 数据库字段或字段名
     * @return array
     */
    public function diyFieldMultiFile($field)
    {
        $model = $this->owner;
        $attribute = (strpos($field, DiyField::FIELD_PRE) === false)?DiyField::FIELD_PRE.$field:$field;
        
        $value = $model->{$attribute};
        if(is_array($value)) {
            return $value;
        } else {
            try {
                $value = Json::decode($value);
            } catch (InvalidArgumentException $e) {//直接忽略跳过
                $value = [];
            }
            
            return is_array($value)?$value:[];//防止null和空的情况
        }
    }
}