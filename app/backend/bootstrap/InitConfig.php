<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\bootstrap;

use Yii;
use app\models\sys\Config;
use yii\helpers\ArrayHelper;

//普通的导入类方式
class InitConfig extends \yii\base\Component implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        //后台管理参数配置
        Yii::$app->params = ArrayHelper::merge(Yii::$app->params, Config::getCache());
    }
}