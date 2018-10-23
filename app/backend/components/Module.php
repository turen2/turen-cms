<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\components;

/**
 * 全局统一模块
 */
class Module extends \yii\base\Module
{
    public static $_normalizeMenus = [];//菜单管理
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public static function renderMenus()
    {
        //子模板参照方法
        return static::$_normalizeMenus;
    }
}
