<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\filters;

use Yii;
use yii\web\User;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
 * 这里完成两件事儿：
 * 1.首先判断创始人。
 * 2.给管理者适配对应的角色权限。
 * 
 * 用法与用量：过滤器中只有以下返回：1.return;    2.return true;     3.return false;   三种
 * AccessControl provides simple access control based on a set of rules.
 * RBAC权限过滤器
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => AcFilter::class,
 *         ],
 *     ];
 * }
 * ```
 */
class AcFilter extends ActionFilter
{
    /**
     * ```php
     * function ($action)
     * ```
     */
    public $denyCallback;
    
    /**
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     * 上述过滤器激活，isActive返回true时，过滤器有效执行beforeAction
     */
    public function beforeAction($action)//返回true下一个filter继续执行，返回false导致action和下一个filter都没有机会执行
    {
        //临时使用
//         if(YII_DEBUG) {
//             return true;
//         }

        $user = Yii::$app->getUser();
        $admin = $user->getIdentity();//后台管理者模型
        $route = $this->getActionId($action);
        
        if(!$user->isGuest) {
            if($admin->checkAccess($route)) {
                return true;
            }
        } else {//未登录跳转
            //标识response为跳转，注意整个框架不仅没有在此处中断，而且还完整的执行了响应，只是这个响应是个header跳转而已
            //这个响应的过程同样要完成正常的layout而已和action执行，因为在layout和所有view模板中，遇到user is guest时，都要return;
            $user->loginRequired();
            return true;
        }
        
        //未审核回调
        if ($this->denyCallback !== null) {
            call_user_func($this->denyCallback, $action);
        }
        
        throw new ForbiddenHttpException('您无权访问，请联系系统责任人');
    }
}