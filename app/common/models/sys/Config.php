<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\sys;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%sys_config}}".
 *
 * @property string $cfg_id
 * @property string $varname 变量名称
 * @property string $varinfo 参数说明
 * @property int $vargroup 所属组
 * @property string $vartype 变量类型
 * @property string $varvalue 变量值
 * @property int $orderid 排列排序
 * @property string $lang 多语言
 */
class Config extends \common\components\ActiveRecord
{
    private static $_config;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_config}}';
    }

    /**
     * 获取指定语言和站点的配置
     * @return array
     */
    public static function getConfigAsArray()
    {
        if(empty(self::$_config)) {
            self::$_config = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        return self::$_config;
    }
    
    /**
     * 获取配置缓存
     * @return string
     */
    public static function CacheList()
    {
        $cache = Yii::$app->getCache();
        if($cacheData = $cache->get(GLOBAL_SYS_CACHE_KEY)) {
            return Json::decode($cacheData);//返回数组
        } else {
            if(self::UpdateCache()) {//就地更新
                return Json::decode($cache->get(GLOBAL_SYS_CACHE_KEY));//返回数组
            } else {
                //更新失败
                throw new ErrorException('更新配置缓存失败！');
            }
        }
    }
    
    /**
     * 更新配置缓存
     * @return boolean
     */
    public static function UpdateCache()
    {
        $cache = Yii::$app->getCache();
        $models = self::find()->current()->all();//缓存网站的配置参数
        if($models) {
            $cache->delete(GLOBAL_SYS_CACHE_KEY);
            
            //处理数组形式的数据
            $cache->set(GLOBAL_SYS_CACHE_KEY, Json::encode(ArrayHelper::map($models, 'varname', 'varvalue')), 3600, new TagDependency(['tags' => Yii::$app->params["config.updateAllCache"]]));
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 删除本站点配置缓存
     * @return boolean
     */
    public static function DeleteCache()
    {
        Yii::$app->getCache()->delete(GLOBAL_SYS_CACHE_KEY);
        return true;
    }

    /**
     * @inheritdoc
     * @return ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigQuery(get_called_class());
    }
}
