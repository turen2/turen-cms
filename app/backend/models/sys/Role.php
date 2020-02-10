<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\sys;

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
class Role extends \backend\models\base\Sys
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
     * 初始化路由数组
     */
    protected function initRoles()
    {
        if(is_null(static::$RoleItems)) {
            foreach (RoleItem::find()->asArray()->all() as $item) {
                static::$RoleItems[$item['role_id']][] = $item['route'].(empty($item['role_params'])?'':'?'.$item['role_params']);
            }
        }
    }
    
    /**
     * 判断权限是否包含
     * @param string $route
     * @return boolean
     */
    public function checkPerm($pattern, $isFounder = false)//checkPerm
    {
        $this->initRoles();

        //菜单需要判断是否为创始人
        if($isFounder && in_array(Yii::$app->getUser()->id, Yii::$app->params['config.founderList'])) {
            return true;
        }

        foreach (static::$RoleItems[$this->role_id] as $route) {
            if(strpos($pattern, '?') !== false) {
                if($pattern == $route) {
                    return true;
                }
                /*
                $pattern = explode('&', $pattern);
                $roleParams = $pattern[1];
                $pattern = $pattern[0];
                if (StringHelper::matchWildcard($pattern, $route) && $roleParams == ) {
                    return true;
                }
                */
            } else {
                if (StringHelper::matchWildcard($pattern, $route)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * 返回指定角色的所有匹配路由，或指定角色和控制器的匹配动作
     * @return array
     */
    public function routeAll()
    {
        $this->initRoles();

        $controllerActions = [];
        foreach (static::$RoleItems[$this->role_id] as $pattern) {
            $roleArr = explode('/', $pattern);
            if(!empty($roleArr)) {
                $action = array_pop($roleArr);
                $controllerActions[implode('/', $roleArr)][] = $action;
            }
        };

        return $controllerActions;
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
