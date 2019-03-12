<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\account;

use Yii;

/**
 * account module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/easy_main';

    public $allowRoutes = [
        'user/login',//登录
        'user/signup',//注册
        'user/logout',//登出
        'user/forget',//忘记密码
    ];

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\account\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
