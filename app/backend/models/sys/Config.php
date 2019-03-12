<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\behaviors\InsertLangBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
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
class Config extends \app\models\base\Sys
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
                    
                    return $this->varvalue;
                }
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_config}}';
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
     * @return array
     */
    public static function ConfigArray()
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
            } else {
                //throw new InvalidArgumentException('无法查询出配置为“'.$model->varname.'”的参数，请先创建！');
            }
        }
        
        //更新前台初始化缓存
        TagDependency::invalidate(Yii::$app->cache, Yii::$app->params['config.updateAllCache']);
        
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
