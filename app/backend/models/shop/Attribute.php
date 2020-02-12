<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\shop;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%shop_attribute}}".
 *
 * @property string $id 商品属性id
 * @property string $pcateid 所属产品分类
 * @property string $attrname 属性名称
 * @property string type 操作类型
 * @property string typetext 操作值
 * @property int $status 审核状态
 * @property string $lang 站点id
 * @property string $orderid 排列排序
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Attribute extends \backend\models\base\Shop
{
	public $keyword;
	
	const TYPE_TEXT = 'text';
	const TYPE_SELECT = 'select';
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_RADIO = 'radio';
	
	private static $_productCateName = [];
	
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
	        'defaultOrderid' => [
	            'class' => OrderDefaultBehavior::class,
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_attribute}}';
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
            [['attrname', 'pcateid'], 'required'],
            [['attrname'], 'unique', 'targetAttribute' => 'attrname'],
            [['pcateid', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['type', 'typetext'], 'string'],
            [['attrname'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pcateid' => '所属产品分类',
            'attrname' => '属性名称',
            'type' => '操作类型',
            'typetext' => '备用值',
            'status' => '审核状态',
            'lang' => '多语言',
            'orderid' => '排序',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    /**
     * 获取所有分类名称
     * @return array|string|mixed
     */
    public function getProductCateName($isAll = false) {
        if(empty(self::$_productCateName)) {
            $arrAttribute = ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach ($arrAttribute as $attribute) {
                self::$_productCateName[$attribute['id']] = $attribute['cname'];
            }
        }
        
        if($isAll) {
            return self::$_productCateName;
        } else {
            return isset(self::$_productCateName[$this->pcateid])?self::$_productCateName[$this->pcateid]:'无分类';
        }
    }
    
    /**
     * 获取操作类型选择列表
     */
    public static function TypeList($val = null)
    {
        $list = [
            self::TYPE_TEXT => '文本类型',
            self::TYPE_SELECT => '下拉选择类型',
            self::TYPE_CHECKBOX => '多选类型',
            self::TYPE_RADIO => '单选类型',
        ];
        if(!is_null($val)) {
            return isset($list[$val])?$list[$val]:[];
        }
        
        return $list;
    }

    /**
     * @inheritdoc
     * @return AttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttributeQuery(get_called_class());
    }
}
