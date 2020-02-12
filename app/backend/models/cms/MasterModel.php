<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\base\InvalidArgumentException;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;
use backend\widgets\diyfield\DiyFieldBehavior;
use backend\behaviors\FlagBehavior;
use backend\behaviors\CateBehavior;
use backend\behaviors\ColumnBehavior;
use backend\behaviors\OrderDefaultBehavior;


/**
 * This is the model class for table "{{%diymodel_master_model}}".
 *
 * @property string $id ID
 * @property string $title 标题
 * @property string $slug 访问链接
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $columnid 栏目ID
 * @property string $parentid 栏目父ID
 * @property string $parentstr 栏目父ID列表
 * @property string $cateid 类别ID
 * @property string $catepid 类别父ID
 * @property string $catepstr 类别父ID列表
 * @property string $flag 标记
 * @property string $author 编辑作者
 * @property string $base_hits 虚拟点击量
 * @property string $hits 点击次数
 * @property string $picurl 缩略图
 * @property string $lang 多语言
 * @property int $status 状态
 * @property string $orderid 排序
 * @property string $posttime 发布时间
 * @property string $updated_at 更新时间
 * @property string $created_at 添加时间
 */
class MasterModel extends \backend\models\base\Cms
{
	public $keyword;
	
	public static $DiyModelId;//切换id
	private static $_DiyModel;//缓存对象
	
	public function behaviors()
	{
	    return [
	        'flagMark' => [
	            'class' => FlagBehavior::class,
	        ],
	        'cateParent' => [
	            'class' => CateBehavior::class,
	        ],
	        'columnParent' => [
	            'class' => ColumnBehavior::class,
	        ],
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
	            'class' => OrderDefaultBehavior::class,
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
        return ArrayHelper::merge(DiyField::DiyFieldRule($this), [
            [['columnid', 'title', 'slug'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'status', 'orderid', 'posttime', 'updated_at', 'created_at'], 'integer'],
            [['title', 'colorval', 'boldval', 'parentstr', 'catepstr', 'flag', 'author', 'picurl', 'lang'], 'string'],
            [['author'], 'default', 'value' => $this->getAdmin()->username],
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['base_hits'], 'default', 'value' => 0],
            [['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(DiyField::DiyFieldRule($this, false), [
            'id' => 'ID',
            'title' => '标题',
            'slug' => '访问链接',
            'columnid' => '所属栏目',
            'parentid' => '栏目父ID',
            'parentstr' => '栏目父ID列表',
            'cateid' => '所属类别',
            'catepid' => '类别父ID',
            'catepstr' => '类别父ID列表',
            'flag' => '标记',
            'author' => '编辑作者',
            'base_hits' => '虚拟点击量',
            'hits' => '点击次数',
            'picurl' => '缩略图',
            'lang' => '多语言',
            'status' => '状态',
            'orderid' => '排序',
            'posttime' => '发布时间',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ]);
    }
    
    /**
     * 返回所有已经开启在列表中显示的字段
     * @return \backend\components\Column[]|array
     */
    public static function DisplayFieldModelList()
    {
        $className = self::class.'_'.self::$DiyModelId;
        $id = Column::ColumnConvert('class2id', $className);
        $fieldModels = DiyField::FieldModelList($id);
        foreach ($fieldModels as $key => $fieldModel) {
            if(empty($fieldModel->list_status)) {
                unset($fieldModels[$key]);
            }
        }
        
        return $fieldModels;
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
