<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\site;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%site_face_config}}".
 *
 * @property string $cfg_name 变量名称
 * @property string $cfg_value 变量值
 * @property string $template_id 模板
 * @property string $lang 多语言
 */
class FaceConfig extends \common\components\ActiveRecord
{
    private static $_config;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_face_config}}';
    }

    /**
     * 获取指定语言和模板的界面配置
     * @return array
     */
    public static function FaceConfigArray()
    {
        if(empty(self::$_config)) {
            self::$_config = self::find()->current()->where(['template_id' => GLOBAL_TEMPLATE_ID])->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        return self::$_config;
    }
    
    /**
     * 获取配置缓存
     * @return string
     */
    public static function FaceCacheList()
    {
        $cache = Yii::$app->getCache();
        if($cacheData = $cache->get(GLOBAL_FACE_CACHE_KEY)) {
            return Json::decode($cacheData);//返回数组
        } else {
            if(self::UpdateFaceCache()) {//就地更新
                return Json::decode($cache->get(GLOBAL_FACE_CACHE_KEY));//返回数组
            } else {
                //更新失败
                throw new ErrorException('更新配置缓存失败！');
            }
        }
    }

    /**
     * 更新界面配置缓存
     * @return boolean
     */
    public static function UpdateFaceCache()
    {
        $cache = Yii::$app->getCache();
        $models = self::find()->current()->where(['template_id' => GLOBAL_TEMPLATE_ID])->all();//缓存网站的界面配置参数
        if($models) {
            $cache->delete(GLOBAL_FACE_CACHE_KEY);

            //处理数组形式的数据
            $cache->set(GLOBAL_FACE_CACHE_KEY, Json::encode(ArrayHelper::map($models, 'cfg_name', 'cfg_value')), 3600, new TagDependency(['tags' => Yii::$app->params["config.updateAllFaceCache"]]));
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除本站点界面配置缓存
     * @return boolean
     */
    public static function DeleteFaceCache()
    {
        Yii::$app->getCache()->delete(GLOBAL_FACE_CACHE_KEY);
        return true;
    }

    /**
     * @inheritdoc
     * @return FaceConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaceConfigQuery(get_called_class());
    }
}
