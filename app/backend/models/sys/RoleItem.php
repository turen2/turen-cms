<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%sys_role_item}}".
 *
 * @property string $role_id 角色id
 * @property string $route 路由名称
 * @property string $role_params 附加参数
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
            [['role_id'], 'integer'],
            [['route'], 'string', 'max' => 50],
            [['role_params'], 'string', 'max' => 100],
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
            'role_params' => '附加参数',
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

                if(strpos($route, '?') !== false) {
                    //$routeArr = explode('?', $route);
                    //$model->route = $routeArr[0];
                    //$model->role_params = $routeArr[1];
                    $route = parse_url($route);
                    $model->route = $route['path'];
                    $model->role_params = $route['query'];
                } else {
                    $model->route = $route;
                    $model->role_params = '';
                }
                
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
