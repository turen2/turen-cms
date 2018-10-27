<?php

namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%sys_multilang_tpl}}".
 *
 * @property int $id 站点ID
 * @property string $site_name 站点名称：简体中文、English、xxx子网站
 * @property int $template_id 模板id
 * @property string $lang 站点语言包，此语言包必须要有模板的支持
 * @property string $key 站点标识，用于站点访问链接优化标识
 * @property int $back_default 是否后台默认
 * @property int $front_default 是否前台默认
 * @property int $orderid 排序
 * @property int $is_visible 是否显示在前台站点切换
 */
class MultilangTpl extends \app\models\base\Sys
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'defaultOrderid' => [
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'orderid',
	                //ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
	            ],
	            'value' => function ($event) {
	            	if(empty($this->orderid)) {
        	            $maxModel = self::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
        	            if($maxModel) {
        	                return $maxModel->orderid + 1;
        	            } else {
        	                return Yii::$app->params['config.orderid'];//配置默认值
        	            }
    	            }
    	            
    	            return $this->orderid;
	            }
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
                        MultilangTpl::updateAll(['back_default' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
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
                        MultilangTpl::updateAll(['front_default' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
                    }
                    return $this->front_default;
                }
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_multilang_tpl}}';
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
            [['lang_name', 'template_id', 'lang', 'key'], 'required'],
            [['template_id', 'back_default', 'front_default', 'orderid', 'is_visible'], 'integer'],
            [['lang_name', 'key'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 50],
            
            //默认值
            [['is_visible'], 'default', 'value' => self::STATUS_ON],
            [['front_default', 'back_default'], 'default', 'value' => self::STATUS_OFF],
            
            //禁止重复
            [['lang_name', 'lang', 'key'], 'unique'],
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
            'template_id' => '指定模板',
            'lang' => '语言包',
            'key' => '站点标识',
            'back_default' => '后台默认',
            'front_default' => '前台默认',
            'orderid' => '排序',
            'is_visible' => '显示在前台',
        ];
    }
    
    /**
     * 一对一联表
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['temp_id' => 'template_id']);
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
        
        if(Config::find()->where(['lang' => $this->lang])->exists()) {
            return true;
        }
        
        //获取默认配置语言
        $tableSchema = Yii::$app->db->schema->getTableSchema(Config::tableName());
        $fields = ArrayHelper::getColumn($tableSchema->columns, 'name', false);
        $primaryKey = Config::primaryKey()[0];
        ArrayHelper::removeValue($fields, $primaryKey);
        ArrayHelper::removeValue($fields, 'lang');
        
        if($model = MultilangTpl::findOne(['back_default' => MultilangTpl::STATUS_ON])) {
            //新建站点配置
            if($data = Config::find()->select($fields)->where(['lang' => $model->lang])->asArray()->all()) {
                //再执行批量插入
                $fields = ArrayHelper::merge($fields, ['lang']);
                
                foreach ($data as $dkey => $dvalue) {
                    $data[$dkey] = ArrayHelper::merge($dvalue, [$this->lang]);
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
        Yii::$app->getSession()->setFlash('success', '多语言站点对应的配置参数已经删除，请知晓。');
        Config::deleteAll(['lang' => $this->lang]);
    }
    
    /**
     * @inheritdoc
     * @return MultilangTplQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilangTplQuery(get_called_class());
    }
}
