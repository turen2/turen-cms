<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%sys_role}}".
 *
 * @property int $role_id 角色id
 * @property string $role_name 角色名称
 * @property string $note 角色描述
 * @property int $status 角色状态
 */
class Role extends \app\models\base\Sys
{
    
    public $keyword;
    
    public static $RoleItems;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_role}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['note'], 'string'],
            [['role_name'], 'string', 'max' => 30],
            [['status'], 'default', 'value' => self::STATUS_ON],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色id',
            'role_name' => '角色名称',
            'note' => '角色描述',
            'status' => '角色状态',
        ];
    }
    
    /**
     * 判断权限是否包含
     * @param string $route
     * @return boolean
     */
    public function checkPerm($route)
    {
        if(!isset(static::$RoleItems[$this->role_id])) {
            static::$RoleItems[$this->role_id] = array_keys(ArrayHelper::map(RoleItem::find()->select(['route'])->where(['role_id' => $this->role_id])->all(), 'route', 'role_id'));
        }
        
        foreach (static::$RoleItems[$this->role_id] as $pattern) {
            if (StringHelper::matchWildcard($pattern, $route)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * @inheritdoc
     * @return RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleQuery(get_called_class());
    }
}
