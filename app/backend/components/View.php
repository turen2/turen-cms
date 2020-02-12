<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\components;

use Yii;

/**
 * @author jorry
 * 为模板统一添加新特性
 *
 */
class View extends \yii\web\View
{
    //当前展示的模型过视图
    public $topFilter;

    public $urlLink;
    
    public $topAlert;
    
    public function init()
    {
        parent::init();
        
        //some code
    }
    
    //统一渲染所有其它模块提供的菜单
    public function renderMenus()
    {
        foreach (Yii::$app->getModules() as $module) {
            $class = '';
            if(is_object($module)) {//模块对象
                $class = get_class($module);
            } else if(is_array($module) && !empty($module['class'])) {//模块类
                $class = $module['class'];
            }
        
            if(!empty($class) && method_exists($class, 'renderMenus')) {
                //模块是独立实例化的，即框架的每次执行正常来讲只实例化了一个module，所以调用此方法使用静态，不需要实例化
                call_user_func([$class, 'renderMenus']);//静态调用后，菜单整理到了Module::$_normalizeMenus变量中了，这里可以统一传入权限参数
            }
        }
        
        //排序处理
        $menus = [];
        foreach (Module::$_normalizeMenus as $item) {
            $menus[$item['sort'].'_'.$item['id']] = $item['content'];//防止键名重叠而覆盖
        }
        
        krsort($menus, SORT_NUMERIC);//ksort();//强制使用数字排序，越大越前
        
        return $menus;
    }
}
