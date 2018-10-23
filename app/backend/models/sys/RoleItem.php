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

/**
 * This is the model class for table "{{%sys_role_item}}".
 *
 * @property string $role_id 角色id
 * @property string $route 路由名称
 * @property string $column_id 栏目id
 */
class RoleItem extends \app\models\base\Sys
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_role_item}}';
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
        //静态默认值由规则来赋值
        return [
            [['route'], 'required'],
            [['role_id', 'column_id'], 'integer'],
            [['route'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色ID',
            'route' => '路由名称',
            'column_id' => '栏目ID',
        ];
    }
    
    /**
     * 批量插入权限项
     * @param array $data
     */
    public static function BatchUpdate($roleId, $data = [])
    {
        if(!empty($data['route'])) {
            //先删除，不用事务
            self::deleteAll(['role_id' => $roleId]);
            
            $model = new self();
            
            foreach ($data['route'] as $route) {
                $model->isNewRecord = true;
                $model->role_id = $roleId;
                $model->route = $route;
                //$model->column_id
                
                $model->save(false);
            }
        }
    }

    /**
     * @inheritdoc
     * @return RoleItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleItemQuery(get_called_class());
    }
}
