<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;

/**
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => 'app\filters\ReturnUrlFilter',
 *             'only' => ['index'],
 *             'except' => ['controller/action', 'controller/*', 'module1/*', 'module2/*'],
 *         ],
 *     ];
 * }
 * ```
 * 解决系统刷新时iframe自动记录当前访问的页面
 * @author jorry
 *
 */
class ReturnUrlFilter extends ActionFilter
{
    const RETURN_RUL_ROUTE = '__return_url_route';
    
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $session = Yii::$app->getSession();

        $id = $action->getUniqueId();
        if(Yii::$app->getRequest()->isAjax || $id == 'error') {//所有ajax不用记录，通用错误页面不记录
            //nothing
            return true;
        }
        
        //有权限的才记录?
        $session->set(self::RETURN_RUL_ROUTE, Url::current());
        return true;
        //if(Yii::$app->getRequest()->isGet) {}
        //$session->remove(self::RETURN_RUL_ROUTE);
    }
}
