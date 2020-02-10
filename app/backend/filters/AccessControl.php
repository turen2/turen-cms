<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\filters;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\sys\Role;
use backend\helpers\BackCommonHelper;

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
        foreach ($this->sysAccessRules($action) as $i => $rule) {
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

    protected function sysAccessRules($action)
    {
        $rules = [];
        //权限管理系统基础权限
        $rules[] = [
            'allow' => true,
            'controllers' => ['site/home'],//iframe框架、菜单
            'actions' => ['index', 'menu'],
            'roles' => ['@'],
        ];
        $rules[] = [
            'allow' => true,
            'actions' => ['diyfield-fileupload', 'diyfield-multiple-fileupload', 'diyfield-ueditor'],//对外开放所有自定义字段，单图、多图、编辑器图片
            'roles' => ['@'],
        ];
        if($this->user->getIsGuest()) {//游客直接返回
            return $rules;
        }

        //权限管理系统角色配置权限
        $userModel = $this->user->identity;
        $roleModel = Role::find()->where(['role_id' => $userModel->role_id])->active()->one();
        if($roleModel) {
            $routeStr = Yii::$app->requestedRoute;
            $routeArr = explode('/', $routeStr);
            $controllerName = substr($routeStr, 0, strlen($routeStr) - strlen(array_pop($routeArr)) - 1);
            $controllerActions = $roleModel->routeAll();

            //控制器和动作规则
            if(isset($controllerActions[$controllerName])) {
                //附加栏目规则
                if($controllerName == 'cms/master-model') {
                    $actions = [];
                    $roleParams = [];
                    foreach ($controllerActions[$controllerName] as $controllerAction) {
                        if(strpos($controllerAction, '?') !== false) {
                            $url = parse_url($controllerAction);
                            $actions[] = $url['path'];
                            $roleParams = ArrayHelper::merge($roleParams, BackCommonHelper::convertUrlQuery($url['query']));
                        } else {
                            $actions[] = $controllerAction;
                        }
                    }
                    $rules[] = [
                        'allow' => true,
                        'controllers' => [$controllerName],
                        'actions' => $actions,
                        'roleParams' => $roleParams,//用于rbac
                        'matchCallback' => function($_this, $action) {//用于自定义参数回调+roleParams参数传值
                            return $_this->roleParams['mid'] == Yii::$app->request->queryParams['mid'];
                        },
                        'roles' => ['@'],//登录用户
                    ];
                } else {
                    $rules[] = [
                        'allow' => true,
                        'controllers' => [$controllerName],
                        'actions' => array_unique($controllerActions[$controllerName]),
                        'roles' => ['@'],//登录用户
                    ];
                }

                //栏目规则【后期开发...】
                /*
                $rules[] = [
                    'allow' => true,
                    'controllers' => [$controllerName],
                    'actions' => array_unique($controllerActions[$controllerName]),
                    'roleParams' => function($rule) {
                        return ['column_id' => 7];
                    },
                    'roles' => ['@'],//登录用户
                ];
                */
            }
        }

        return $rules;
    }
}