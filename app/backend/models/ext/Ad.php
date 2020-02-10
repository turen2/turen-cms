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
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use backend\behaviors\ParentBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%ext_ad}}".
 *
 * @property string $id 信息id
 * @property string $ad_type_id 投放范围(广告位)
 * @property string $parentid 所属广告位父id
 * @property string $parentstr 所属广告位父id字符串
 * @property string $title 广告标题
 * @property string $admode 展示模式
 * @property string $picurl 上传内容地址
 * @property string $adtext 展示内容
 * @property string $linkurl 跳转链接
 * @property string $orderid 排列排序
 * @property string $posttime 提交时间
 * @property int $status 显示状态
 * @property string $lang
 */
class Ad extends \backend\models\base\Ext
{
	public $keyword;
	
	private static $_adTypeName;

	public function behaviors()
	{
	    return [
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
	        ],
            'adParent' => [
                'class' => ParentBehavior::class,
                'parentPrimaryField' => 'id',
                'parentidField' => 'parentid',
                'parentidStrField' => 'parentstr',
                'parentClassName' => AdType::class,
                'foreignField' => 'ad_type_id',//外键
                'pidField' => 'parentid',
                'pStrField' => 'parentstr',
            ],
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at',
	        ],
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
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
	    ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ext_ad}}';
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
            [['ad_type_id', 'title'], 'required'],
            [['ad_type_id', 'parentid', 'orderid', 'posttime'], 'integer'],
            [['adtext'], 'string'],
            [['parentstr'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 30],
            [['admode'], 'string', 'max' => 10],
            [['picurl'], 'string', 'max' => 100],
            [['linkurl'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '信息id',
            'ad_type_id' => '所在广告位',
            'parentid' => '所属广告位父id',
            'parentstr' => '所属广告位父id字符串',
            'title' => '广告标题',
            'admode' => '展示模式',
            'picurl' => '上传内容地址',
            'adtext' => '展示内容',
            'linkurl' => '跳转链接',
            'orderid' => '排列排序',
            'posttime' => '提交时间',
            'status' => '显示状态',
            'lang' => '多语言',
        ];
    }

    /**
     * 获取所有分类名称
     * @param bool $isAll
     * @param bool $hasSize
     * @return string
     */
    public function getAdTypeName($isAll = false, $hasSize = false) {
        if(empty(self::$_adTypeName)) {
            $arrAdType = AdType::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach ($arrAdType as $type) {
                self::$_adTypeName[$type['id']] = $type['typename'].($hasSize?(' '.$type['width'].'x'.$type['height']):'');
            }
        }
        
        if($isAll) {
            return self::$_adTypeName;
        } else {
            return isset(self::$_adTypeName[$this->ad_type_id])?self::$_adTypeName[$this->ad_type_id]:'无分类';
        }
    }

    /**
     * @inheritdoc
     * @return AdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdQuery(get_called_class());
    }
}
