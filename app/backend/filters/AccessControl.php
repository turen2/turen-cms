<?php
/**
 * Created by PhpStorm.
 * User: jorry
 * Date: 2019/3/29
 * Time: 14:48
 */

namespace app\filters;

use app\models\sys\Role;
use app\models\sys\RoleItem;
use Yii;

class AccessControl extends \yii\filters\AccessControl
{
    public function beforeAction($action)
    {
        $user = $this->user;
        $request = Yii::$app->getRequest();

        //创始人
        if(in_array($user->id, Yii::$app->params['config.founderList'])) {
            return true;
        }

        //权限控制
        foreach ($this->sysAccessRules() as $i => $rule) {
            $this->rules[] = Yii::createObject(array_merge($this->ruleConfig, $rule));//统一生成规则对象
        }

        foreach ($this->rules as $rule) {
            if ($allow = $rule->allows($action, $user, $request)) {
                return true;
            } elseif ($allow === false) {
                if (isset($rule->denyCallback)) {
                    call_user_func($rule->denyCallback, $rule, $action);
                } elseif ($this->denyCallback !== null) {
                    call_user_func($this->denyCallback, $rule, $action);
                } else {
                    $this->denyAccess($user);
                }

                return false;
            }
        }
        if ($this->denyCallback !== null) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess($user);
        }

        return false;
    }

    protected function sysAccessRules()
    {
        $rules = [];
        //权限管理系统基础权限
        $rules[] = [
            'allow' => true,
            'controllers' => ['site/home'],//iframe框架、菜单
            'actions' => ['index', 'menu'],
            'roles' => ['@'],
        ];
        if($this->user->getIsGuest()) {//游客直接返回
            return $rules;
        }

        //权限管理系统角色配置权限
        $userModel = $this->user->identity;
        $roleModel = Role::find()->where(['role_id' => $userModel->role_id])->active()->one();
        if($roleModel) {
            $controllerActions = [];
            foreach (RoleItem::findAll(['role_id' => $userModel->role_id]) as $item) {
                $roleArr = explode('/', $item->route);
                if(count($roleArr) == 3) {
                    $controllerActions[$roleArr[0].'/'.$roleArr[1]][] = $roleArr[2];
                } else {
                    continue;
                }
            };

            foreach ($controllerActions as $controller => $actions) {
                $rules[] = [
                    'allow' => true,
                    'controllers' => [$controller],
                    'actions' => array_unique($actions),
                    'roles' => ['@'],
                ];
            }
        }

        return $rules;
    }
}