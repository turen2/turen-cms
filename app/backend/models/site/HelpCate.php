<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\site;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%site_help_cate}}".
 *
 * @property string $id 二级帮助分类id
 * @property string $parentid 帮助分类上级id
 * @property string $parentstr 帮助分类上级id字符串
 * @property string $catename 帮助分类名称
 * @property string $orderid 排列排序
 * @property int $status 审核状态
 */
class HelpCate extends \backend\models\base\Site
{
	public $keyword;
	
	public $level;
	
	private static $_allCate;

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
        return '{{%site_help_cate}}';
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
            [['parentid', 'orderid', 'orderid', 'status'], 'integer'],
            [['parentid', 'catename'], 'required'],
            [['parentstr', 'keywords'], 'string', 'max' => 50],
            [['catename'], 'string', 'max' => 30],
            [['linkurl', 'description'], 'string', 'max' => 255],
            [['seotitle'], 'string', 'max' => 80],
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
            
            //不允许把自己插入到自己的下级里面
            $children = HelpCate::find()->select('id')->where(['like', 'parentstr', ','.$this->id.','])->asArray()->all();
            if(!empty($children) && in_array($this->parentid, ArrayHelper::getColumn($children, 'id'))) {
                $this->addError($attribute, '不能将当前项移入到自己的下级。');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '所属帮助分类',
            'parentid' => '所属上级帮助分类',
            'parentstr' => '上级所属帮助分类字符串',
            'catename' => '帮助分类名称',
            'linkurl' => '跳转链接',
            'seotitle' => 'SEO标题',
            'keywords' => 'SEO关键词',
            'description' => 'SEO描述', 
            'orderid' => '排列排序',
            'status' => '审核状态',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 获取所有类别列表
     * @return array
     */
    public static function CateList() {
        if(empty(self::$_allCate)) {
            self::$_allCate = self::find()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach (self::$_allCate as $cate) {
                self::$_allCate[$cate['id']] = $cate;
            }
        }
        
        return self::$_allCate;
    }
    
    /**
     * 类别名称
     * @param integer $cateid
     * @return string|string|mixed
     */
    public static function CateName($cateid = null) {
        $name = '未定义';
        $cateList = self::CateList();
        if(is_null($cateid)) {
            return $name;
        } else {
            return isset($cateList[$cateid])?$cateList[$cateid]['catename']:$name;
        }
    }
    
    /**
     * @inheritdoc
     * @return HelpCateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HelpCateQuery(get_called_class());
    }
}
