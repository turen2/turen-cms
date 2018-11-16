<?php

namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;
use app\widgets\laydate\LaydateBehavior;
use yii\base\InvalidArgumentException;

/**
 * This is the model class for table "{{%diymodel_master_model}}".
 *
 * @property string $id ID
 * @property string $title 标题
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $columnid 栏目ID
 * @property string $parentid 栏目父ID
 * @property string $parentstr 栏目父ID列表
 * @property string $cateid 类别ID
 * @property string $catepid 类别父ID
 * @property string $catepstr 类别父ID列表
 * @property string $flag 标记
 * @property string $picurl 缩略图
 * @property string $lang 多语言
 * @property int $status 状态
 * @property string $orderid 排序
 * @property string $posttime 发布时间
 * @property string $updated_at 更新时间
 * @property string $created_at 添加时间
 */
class MasterModel extends \app\models\base\Cms
{
	public $keyword;
	
	private static $_DiyModel;//缓存对象
	public static $DiyModelId;//切换id
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertlang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
	        ],
	        //动态值由此属性行为处理
	        'defaultPosttime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'posttime',
	            'updatedAtAttribute' => false,
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
        if(empty(self::$DiyModelId)) {
            throw new InvalidArgumentException('使用此类之前请先赋值MasterModel::$DiyModelId为正确的id');
        }
        
        if(empty(self::$_DiyModel)) {
            self::$_DiyModel = DiyModel::find()->active()->andWhere(['dm_id' => self::$DiyModelId])->one();
        }
        
        if(empty(self::$_DiyModel)) {
            throw new InvalidArgumentException('MasterModel没有找到正确的模型');
        }
        
        return '{{%'.DiyModel::MODEL_PRE.self::$_DiyModel->dm_tbname.'}}';
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
            [['columnid', 'cateid', 'title'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'status', 'orderid', 'posttime', 'updated_at', 'created_at'], 'integer'],
            [['title', 'parentstr', 'catepstr', 'flag', 'picurl', 'lang'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_ON],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'columnid' => '所属栏目',
            'parentid' => '栏目父ID',
            'parentstr' => '栏目父ID列表',
            'cateid' => '所属类别',
            'catepid' => '类别父ID',
            'catepstr' => '类别父ID列表',
            'flag' => '标记',
            'picurl' => '缩略图',
            'lang' => '多语言',
            'status' => '状态',
            'orderid' => '排序',
            'posttime' => '发布时间',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ];
    }
    
    /**
     * @inheritdoc
     * @return MasterModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasterModelQuery(get_called_class());
    }
}
