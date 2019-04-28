<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account\filters;

use Yii;
use yii\base\ActionFilter;

/**
 * 用法与用量：过滤器中只有以下返回：1.return;    2.return true;     3.return false;   三种
 * 权限过滤器，不使用rbac
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => \app\modules\account\filters\AccessFilter::class,
 *             'denyCallback' => function($action) {...},
 *         ],
 *     ];
 * }
 * ```
 */
class AccessFilter extends ActionFilter
{
    public $denyCallback;//回调函数
    
    /**
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     * 上述过滤器激活，isActive返回true时，过滤器有效执行beforeAction
     * 返回true下一个filter继续执行，返回false导致action和下一个filter都没有机会执行
     */
    public function beforeAction($action)
    {
        $user = Yii::$app->user;
        if (Yii::$app->user->getIsGuest()) {//未登录
            Yii::$app->session->setFlash('warning', '您还未登录，请先登录再操作！');
            $user->loginRequired();//跳转到登录，并保留当前将访问的地址
            return;//直接返回，当前不处在控制器中，不能跳转
        }

        return true;//正常返回beforeAction
    }
    
    /**
     * @inheritdoc
     * 过滤器是否为激活状态：
     * 仅代表filter是否执行，即是否允许将要执行的filter执行！它并不终止action的执行
     */
    protected function isActive($action)
    {
        //allowAction，任何控制器中定义了allowAction方法，然后返回对应的数组控制器，同样可以实现避开权限认证
        //allowAction方法返回路由的全路径数组！
        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
            return false;//允许，则过滤器被忽略
        } else {
            //不允许直接访问，记录点什么。。。。。
            if ($this->denyCallback !== null) {
                call_user_func($this->denyCallback, $action);
            }

            return parent::isActive($action);//使only和expect保持有效
        }
    }
}