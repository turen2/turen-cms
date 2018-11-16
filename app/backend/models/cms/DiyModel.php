<?php

namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\models\cms\migrations\ModelMigration;
use app\widgets\diyfield\DiyFieldBehavior;

/**
 * This is the model class for table "{{%diy_model}}".
 *
 * @property string $dm_id 自定义模型id
 * @property string $dm_title 模型标题
 * @property string $dm_name 模型名称
 * @property string $dm_tbname 模型表名
 * @property string $orderid 排列排序
 * @property int $status 审核状态
 * @property string $created_at 添加时间
 * @property string $updated_at 更新时间
 */
class DiyModel extends \app\models\base\Cms
{
	const MODEL_PRE = 'diymodel_';
	
	public $keyword;
	//标题    标记    缩略图    多语言    排序    发布时间    更新时间    创建时间
	private static $Default_fields = ['title' => '标题', 'flag' => '标记', 'picurl' => '缩略图', 'lang' => '多语言', 'orderid' => '排序', 'status' => '状态', 'posttime' => '发布时间', 'updated_at' => '创建时间',  'created_at' => '创建时间'];
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
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
            //自定义字段
            'diyField' => [
                'class' => DiyFieldBehavior::class,
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diy_model}}';
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
        return ArrayHelper::merge(parent::rules(), [
            [['dm_title', 'dm_name', 'dm_tbname'], 'required'],
            [['orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['dm_title', 'dm_name', 'dm_tbname'], 'string', 'max' => 30],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_id' => 'ID',
            'dm_title' => '模型标题',
            'dm_name' => '模型名称',
            'dm_tbname' => '模型表名',
            'orderid' => '排序',
            'status' => '开启状态',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public static function DefaultFieldList()
    {
        return self::$Default_fields;
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        //只在插入时处理
        if($insert) {
            //如果是第一条，重新生成主键
            if(empty(self::find()->count('dm_id'))) {
                $columnids = Column::ColumnConvert('mask2id');//系统默认已经占用了一部分模型id
                if(!empty($columnids) && rsort($columnids)) {
                    $this->dm_id = $columnids[0] + 1;
                }
            }
            
            //创建数据库migration
            $migration = Yii::createObject([
                'class' => ModelMigration::class,
                'tableName' => DiyModel::MODEL_PRE.$this->dm_tbname,
            ]);
            
            //升级数据库
            $migration->up();
        }
        
        return true;
    }
    
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        //创建数据库migration
        $migration = Yii::createObject([
            'class' => ModelMigration::class,
            'tableName' => DiyModel::MODEL_PRE.$this->dm_tbname,
        ]);
        
        //降级数据库
        $migration->down();
        
        return true;
    }

    /**
     * @inheritdoc
     * @return DiyModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiyModelQuery(get_called_class());
    }
}
