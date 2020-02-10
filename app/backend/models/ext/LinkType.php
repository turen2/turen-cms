<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%ext_link_type}}".
 *
 * @property string $id 友情链接类型id
 * @property string $parentid 类别父id
 * @property string $parentstr 类别父id字符串
 * @property string $typename 类别名称
 * @property string $orderid 排列顺序
 * @property int $status 显示状态
 * @property string $lang
 */
class LinkType extends \backend\models\base\Ext
{
	public $keyword;
	
	public $level;
	
	public function behaviors()
	{
	    return [
	        'parentString' => [
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'parentstr',
	                ActiveRecord::EVENT_BEFORE_UPDATE => 'parentstr',
	            ],
	            'value' => function ($event) {
    	            //添加和编辑，都要处理parentstr
    	            return $this->initParentStr();
	            },
            ],
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        //动态值由此属性行为处理
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
        return '{{%ext_link_type}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), ['keyword']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid', 'typename'], 'required'],
            [['parentid', 'orderid'], 'integer'],
            [['parentstr'], 'string', 'max' => 50],
            [['typename'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            ['parentid', 'validateParentIdIsNotSelf'],
        ];
    }

    /**
     * 上级验证
     * @param string $attribute
     * @param [] $params
     */
    public function validateParentIdIsNotSelf($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->id == $this->parentid) {
                $this->addError($attribute, '所属上级不能指向自身。');
            }
        }
        
        //不允许把自己插入到自己的下级里面
        $children = LinkType::find()->select('id')->current()->where(['like', 'parentstr', ','.$this->id.','])->asArray()->all();
        if(!empty($children) && in_array($this->parentid, ArrayHelper::getColumn($children, 'id'))) {
            $this->addError($attribute, '不能将当前项移入到自己的下级。');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '友情链接类型id',
            'parentid' => '所属链接组',
            'parentstr' => '类别父id字符串',
            'typename' => '类别名称',
            'orderid' => '排列顺序',
            'status' => '显示状态',
            'lang' => '多语言',
        ];
    }
    
    /**
     * @inheritdoc
     * @return LinkTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkTypeQuery(get_called_class());
    }
}
