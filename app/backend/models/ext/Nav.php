<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\InsertLangBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%ext_nav}}".
 *
 * @property string $id 导航id
 * @property string $parentid 导航分类
 * @property string $parentstr 导航分类父id字符串
 * @property string $menuname 导航名称
 * @property string $linkurl 跳转链接
 * @property string $picurl 导航图片
 * @property string $target 打开方式
 * @property string $orderid 排列排序
 * @property int $status 隐藏导航
 * @property string $lang
 */
class Nav extends \app\models\base\Ext
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
        return '{{%ext_nav}}';
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
            [['parentid', 'menuname', 'linkurl'], 'required'],
            [['parentid', 'orderid'], 'integer'],
            [['picurl'], 'string', 'max' => 100],
            [['parentstr'], 'string', 'max' => 80],
            [['menuname', 'target'], 'string', 'max' => 30],
            [['linkurl'], 'string', 'max' => 255],
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
        $children = Nav::find()->select('id')->current()->where(['like', 'parentstr', ','.$this->id.','])->asArray()->all();
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
            'id' => '导航id',
            'parentid' => '导航分类',
            'parentstr' => '导航分类父id字符串',
            'menuname' => '导航名称',
            'linkurl' => '跳转链接',
            'picurl' => '导航图片',
            'target' => '打开方式',
            'orderid' => '排列排序',
            'status' => '隐藏导航',
            'lang' => '多语言',
        ];
    }
    
    /**
     * @inheritdoc
     * @return NavQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NavQuery(get_called_class());
    }
}
