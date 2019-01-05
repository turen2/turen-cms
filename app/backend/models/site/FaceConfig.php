<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\site;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\behaviors\InsertLangBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\base\ErrorException;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%site_face_config}}".
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
class FaceConfig extends \app\models\base\Site
{
    private static $_config;
    
    public function behaviors()
    {
        return [
            'insertLang' => [//自动填充多站点和多语言
                'class' => InsertLangBehavior::class,
                'insertLangAttribute' => 'lang',
            ],
            'varvalueDeal' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'varvalue',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'varvalue',
                ],
                'value' => function ($event) {
                    if($this->vartype == 'checkbox') {
                        if(is_array($this->varvalue)) {
                            return implode('|', $this->varvalue);
                        }
                    }
                    
                    return $this->vartype;
                }
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_face_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['varname', 'varinfo', 'vargroup', 'vartype', 'varvalue'], 'required'],
            [['cfg_id', 'vargroup', 'orderid'], 'integer'],
            [['varvalue', 'vardefault'], 'string'],
            [['varname'], 'string', 'max' => 50],
            [['varinfo'], 'string', 'max' => 80],
            [['vartype'], 'string', 'max' => 10],
            [['lang'], 'string', 'max' => 8],
            [['varname'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cfg_id' => '配置ID',
            'varname' => '变量名称',
            'varinfo' => '参数说明',
            'vargroup' => '所属组',
            'vartype' => '变量类型',
            'varvalue' => '变量值',
            'vardefault' => '默认参考值',
            'orderid' => '排列排序',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 获取指定语言和站点的配置
     * @param unknown $lang
     */
    public static function getConfigAsArray()
    {
        if(empty(self::$_config)) {
            self::$_config = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        return self::$_config;
    }
    
    /**
     * 批量更新配置数据
     * @param array $data
     * @return boolean
     */
    public static function batchSave(array $data)
    {
        $csrfParam = Yii::$app->getRequest()->csrfParam;
        if(isset($data[$csrfParam])) {
            unset($data[$csrfParam]);
        }
        
        $models = self::find()->current()->all();
        foreach ($models as $model) {
            if(isset($data[$model->varname]) && $model->varvalue != $data[$model->varname]) {
                self::updateAll(['varvalue' => $data[$model->varname]], ['varname' => $model->varname, 'lang' => GLOBAL_LANG]);
                //$model->setAttribute('varvalue', $data[$model->varname]);
                //if($model->getOldAttribute('varvalue') != $model->getAttribute('varvalue')) {
                    //$model->save(false);//不验证保存
                    //self::updateAll(['varvalue' => $data[$model->varname]], ['varname' => $model->varname]);
                //}
            } else {
                //throw new InvalidArgumentException('无法查询出配置为“'.$model->varname.'”的参数，请先创建！');
            }
        }
        
        //更新前台初始化缓存
        TagDependency::invalidate(Yii::$app->cache, Yii::$app->params['config.updateAllCache']);
        
        return true;
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
            $cache->delete(CONFIG_FACE_CACHE_KEY);
            
            //处理数组形式的数据
            $cache->set(CONFIG_FACE_CACHE_KEY, Json::encode(ArrayHelper::map($models, 'varname', 'varvalue')));
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取配置缓存
     * @return string
     */
    public static function CacheList()
    {
        $cache = Yii::$app->getCache();
        if($cacheData = $cache->get(CONFIG_FACE_CACHE_KEY)) {
            return Json::decode($cacheData);//返回数组
        } else {
            if(self::UpdateCache()) {//就地更新
                return Json::decode($cache->get(CONFIG_FACE_CACHE_KEY));//返回数组
            } else {
                //更新失败
                throw new ErrorException('更新配置缓存失败！');
            }
        }
    }
    
    /**
     * 删除本站点配置缓存
     * @return boolean
     */
    public static function DeleteCache()
    {
        Yii::$app->getCache()->delete(CONFIG_FACE_CACHE_KEY);
        return true;
    }

    /**
     * @inheritdoc
     * @return ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaceConfigQuery(get_called_class());
    }
}
