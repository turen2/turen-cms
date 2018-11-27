<?php

namespace app\models\shop;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\behaviors\InsertLangBehavior;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%shop_brand}}".
 *
 * @property string $id 品牌id
 * @property string $bname 品牌名称
 * @property string $picurl 品牌图片
 * @property string $bnote 品牌介绍
 * @property string $linkurl 跳转链接
 * @property string $orderid 排列排序
 * @property string $lang 多语言
 * @property int $status 审核状态
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Brand extends \app\models\base\Shop
{
	public $keyword;
	
	private static $_allBrand;
	
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
        return '{{%shop_brand}}';
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
            [['bname', 'bnote', 'picurl'], 'required'],
            [['bnote'], 'string'],
            [['orderid', 'created_at', 'updated_at'], 'integer'],
            [['bname'], 'string', 'max' => 30],
            [['picurl'], 'string', 'max' => 100],
            [['linkurl'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 8],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bname' => '品牌名称',
            'picurl' => '品牌图片',
            'bnote' => '品牌介绍',
            'linkurl' => '跳转链接',
            'orderid' => '排列排序',
            'lang' => '多语言',
            'status' => '审核状态',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }

    /**
     * 获取所有品牌列表
     * @return array
     */
    public static function BrandList() {
        if(empty(self::$_allBrand)) {
            self::$_allBrand = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach (self::$_allBrand as $brand) {
                self::$_allBrand[$brand['id']] = $brand;
            }
        }
        
        return self::$_allBrand;
    }
    
    /**
     * 品牌名称
     * @param integer $brandid
     * @return string|string|mixed
     */
    public static function BrandName($brandid = null) {
        $name = '未定义';
        $brandList = self::BrandList();
        if(is_null($brandid)) {
            return $name;
        } else {
            return isset($brandList[$brandid])?$brandList[$brandid]['bname']:$name;
        }
    }
    
    /**
     * @inheritdoc
     * @return BrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BrandQuery(get_called_class());
    }
}
