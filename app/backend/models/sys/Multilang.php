<?php

namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use app\behaviors\ClearCacheBehavior;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%sys_multilang}}".
 *
 * @property int $id 站点ID
 * @property string $site_name 站点名称：简体中文、English、xxx子网站
 * @property string $lang_sign 站点语言包，此语言包必须要有模板的支持
 * @property string $key 站点标识，用于站点访问链接优化标识
 * @property int $back_default 是否后台默认
 * @property int $front_default 是否前台默认
 * @property int $orderid 排序
 * @property int $is_visible 是否显示在前台站点切换
 */
class Multilang extends \app\models\base\Sys
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'defaultOrderid' => [
	            'class' => OrderDefaultBehavior::class,
            ],
            //后台默认打开
            'defaultBack' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'back_default',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'back_default',
                ],
                'value' => function ($event) {
                    if(!empty($this->back_default)) {
                        Multilang::updateAll(['back_default' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
                    }
                    return $this->back_default;
                }
            ],
            //前台默认打开
            'defaultFront' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'front_default',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'front_default',
                ],
                'value' => function ($event) {
                    if(!empty($this->front_default)) {
                        Multilang::updateAll(['front_default' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
                    }
                    return $this->front_default;
                }
            ],
            //更新所有前台缓存
            'clearFrontCache' => [
                'class' => ClearCacheBehavior::class,
                'cache' => Yii::$app->cache,
                'tagName' => Yii::$app->params['config.updateAllCache'],
            ],
	    ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_multilang}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //静态默认值由规则来赋值
        //[['status'], 'default', 'value' => self::STATUS_ON],
        //[['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        return [
            [['lang_name', 'lang_sign', 'key'], 'required'],
            [['back_default', 'front_default', 'orderid', 'is_visible'], 'integer'],
            [['lang_name', 'key'], 'string', 'max' => 30],
            [['lang_sign'], 'string', 'max' => 50],
            
            //默认值
            [['is_visible'], 'default', 'value' => self::STATUS_ON],
            [['front_default', 'back_default'], 'default', 'value' => self::STATUS_OFF],
            
            //禁止重复
            [['lang_name', 'lang_sign', 'key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '站点ID',
            'lang_name' => '站点名称',
            'lang_sign' => '语言包',
            'key' => '站点标识',
            'back_default' => '后台默认',
            'front_default' => '前台默认',
            'orderid' => '排序',
            'is_visible' => '显示在前台',
        ];
    }
    
    /**
     * 创建多语言站点之前配置参数
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeSave()
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if(Config::find()->where(['lang' => $this->lang_sign])->exists()) {
            return true;
        }
        
        //获取默认配置语言
        $tableSchema = Yii::$app->db->schema->getTableSchema(Config::tableName());
        $fields = ArrayHelper::getColumn($tableSchema->columns, 'name', false);
        $primaryKey = Config::primaryKey()[0];
        ArrayHelper::removeValue($fields, $primaryKey);
        ArrayHelper::removeValue($fields, 'lang');
        
        if($model = Multilang::findOne(['back_default' => Multilang::STATUS_ON])) {
            //新建站点配置
            if($data = Config::find()->select($fields)->where(['lang' => $model->lang_sign])->asArray()->all()) {
                //再执行批量插入
                $fields = ArrayHelper::merge($fields, ['lang']);
                
                foreach ($data as $dkey => $dvalue) {
                    $data[$dkey] = ArrayHelper::merge($dvalue, [$this->lang_sign]);
                }
                
                Yii::$app->getSession()->setFlash('success', '多语言站点对应的配置参数已经同步为默认站点参数，请知晓。');
                Yii::$app->db->createCommand()->batchInsert(Config::tableName(), $fields, $data)->execute();
                return true;
            }
        }
        
        Yii::$app->getSession()->setFlash('warning', '未设置后台默认站点，不能再创建站点，详情请看：系统管理-多语言管理。');
        return false;
    }
    
    /**
     * 删掉一个多语言站点，同时清空对应的配置
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterDelete()
     */
    public function afterDelete()
    {
        parent::afterDelete();
        
        Yii::$app->getSession()->setFlash('success', '多语言站点对应的配置参数已经删除，请知晓。');
        Config::deleteAll(['lang' => $this->lang_sign]);
    }
    
    /**
     * @inheritdoc
     * @return MultilangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilangQuery(get_called_class());
    }
}
