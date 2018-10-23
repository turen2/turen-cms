<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\bootstrap;

use Yii;
use yii\base\InvalidConfigException;
use app\models\sys\Template;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\Json;
use app\filters\ReturnUrlFilter;

/**
 * 系统初始化生成了全局参数以"config_init_"为前缀
 * 普通的导入类方式
 */
class InitSysten extends \yii\base\Component implements \yii\base\BootstrapInterface
{
    const INIT_PARAMS = '__init_params';
    const INIT_LAGN = '__init_lang';//切换后的语言session
    
    public function bootstrap($app)
    {
        $session = Yii::$app->session;
        
        //手动切换
        if($lang = Yii::$app->request->post('lang')) {
            $session->set(self::INIT_LAGN, $lang);
            $session->remove(self::INIT_PARAMS);
            //内容+构架，整体刷新
            Yii::$app->getSession()->remove(ReturnUrlFilter::RETURN_RUL_ROUTE);
            Yii::$app->getResponse()->refresh('#lang');
        } else {
            $session->remove(self::INIT_LAGN);
        }
        
        //读取历史记录
        if($session->has(self::INIT_PARAMS)) {
            $params = $session->get(self::INIT_PARAMS);
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);//$params['config_init_langs'];//$params['config_init_default_lang'];//$params['config_init_open_cate'];
        } else {
            if(isset(Yii::$app->params['config.templateId'])) {
                $template = (new Query())->from(Template::tableName())->where(['temp_id' => Yii::$app->params['config.templateId']])->one();
                if($template) {
                    $params = [
                        'config_init_langs' => Json::decode($template['langs']),
                        'config_init_default_lang' => $session->has(self::INIT_LAGN)?$session->get(self::INIT_LAGN):$template['default_lang'],//优先使用动手切换的值
                        'config_init_open_cate' => $template['open_cate'],
                    ];
                    
                    $session->set(self::INIT_PARAMS, $params);
                    Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
                } else {
                    throw new InvalidConfigException('Yii::$app->params[\'config.templateId\']找不到对应的模板。');
                }
            } else {
                throw new InvalidConfigException('系统config/params.php配置项"config.templateId"未定义。');
            }
        }
        
        define('GLOBAL_LANG', Yii::$app->params['config_init_default_lang']);
        define('CONFIG_CACHE_KEY', 'sys.cache.'.GLOBAL_LANG);
    }
}