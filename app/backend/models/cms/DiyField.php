<?php

namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%diy_field}}".
 *
 * @property string $id 自定义字段id
 * @property string $fd_mclass 所属模型
 * @property int $columnid_list 所属栏目
 * @property string $fd_name 字段名称
 * @property string $fd_title 字段标题
 * @property string $fd_desc 字段提示
 * @property string $fd_type 字段类型
 * @property string $fd_long 字段长度
 * @property string $fd_value 字段选项值
 * @property string $fd_check 校验正则
 * @property string $fd_tips 未通过提示
 * @property string $lang 多语言
 * @property string $orderid 排列排序
 * @property int $status 是否生效
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class DiyField extends \app\models\base\Cms
{
	public $keyword;
	
	private static $_allColumn;
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertLang' => [//自动填充多站点和多语言
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
        return '{{%diy_field}}';
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
        return [
            [['columnid_list', 'fd_title', 'fd_mclass', 'fd_name', 'fd_type', 'fd_long'], 'required'],
            [['orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['lang', 'fd_mclass', 'columnid_list', 'fd_name', 'fd_title', 'fd_type', 'fd_tips', 'fd_long', 'fd_desc', 'fd_value', 'fd_check'], 'string'],
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
            'fd_mclass' => '所属模型',
            'columnid_list' => '所属栏目',
            'fd_name' => '字段名',
            'fd_title' => '字段标题',
            'fd_desc' => '字段提示',
            'fd_type' => '字段类型',
            'fd_long' => '字段长度',
            'fd_value' => '字段选项值',
            'fd_check' => '校验正则',
            'fd_tips' => '未通过提示',
            'lang' => '多语言',
            'orderid' => '排列排序',
            'status' => '是否生效',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    public function columnList()
    {
        if(empty(self::$_allColumn)) {
            self::$_allColumn = ArrayHelper::map(Column::find()->where('1=1')->all(), 'id', 'cname');
        }
        
        $columnNameList = [];
        foreach (explode(',', $this->columnid_list) as $columnid) {
            $columnNameList[$columnid] = isset(self::$_allColumn[$columnid])?self::$_allColumn[$columnid]:'未定义';
        }
        
        return $columnNameList;
    }
    
    /**
     * @inheritdoc
     * @return DiyFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiyFieldQuery(get_called_class());
    }
}
