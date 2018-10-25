<?php

namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%user_level}}".
 *
 * @property int $level_id 用户组id
 * @property string $level_name 用户组名称
 * @property string $level_expval_min 用户组经验介于a
 * @property string $level_expval_max 用户组经验介于b
 * @property string $orderid 排序
 * @property string $lang 多语言
 * @property int $is_default 是否默认
 */
class Level extends \app\models\base\User
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'insertlang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
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
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_level}}';
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
            [['level_name'], 'required'],
            [['level_expval_min', 'level_expval_max'], 'integer'],
            [['orderid'], 'integer'],
            [['is_default'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => 'ID',
            'level_name' => '用户组名称',
            'level_expval_min' => '最小经验',
            'level_expval_max' => '最大经验',
            'orderid' => '排序',
            'lang' => '多语言',
            'is_default' => '是否默认',
        ];
    }

    /**
     * @inheritdoc
     * @return LevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LevelQuery(get_called_class());
    }
}
