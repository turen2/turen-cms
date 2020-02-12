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
use yii\helpers\Json;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;
use backend\widgets\fileupload\MultiPicBehavior;
use backend\widgets\diyfield\DiyFieldBehavior;
use backend\models\cms\DiyField;
use backend\behaviors\FlagBehavior;
use backend\behaviors\ProductCateBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%shop_product}}".
 *
 * @property string $id 商品id
 * @property string $columnid 所属栏目
 * @property string $pcateid 商品分类
 * @property string $attrtext 属性json值
 * @property int $brand_id 商品品牌id
 * @property string $title 商品名称
 * @property string $slug 链接别名
 * @property string $colorval 标题颜色
 * @property string $boldval 标题加粗
 * @property string $subtitle 副标题
 * @property string $keywords 关键词
 * @property string $description 摘要
 * @property string $flag 属性
 * @property string $sku 产品SKU
 * @property string $product_sn 货号
 * @property string $weight 重量
 * @property double $market_price 市场价格
 * @property double $sales_price 销售价格
 * @property int $is_promote 是否促销
 * @property string $promote_price 促销价
 * @property string $promote_start_date 促销开始日期
 * @property string $promote_end_date 促销结束日期
 * @property int $stock 库存数量
 * @property int $is_shipping 是否配送
 * @property string $linkurl 跳转链接
 * @property string $content 详细内容
 * @property string $picurl 缩略图片
 * @property string $picarr 组图
 * @property int $is_best 最爱
 * @property int $is_new 新品
 * @property int $is_hot 最热
 * @property string $base_hits 虚拟点击量
 * @property string $hits 点击次数
 * @property string $orderid 排列排序
 * @property string $posttime 上架时间
 * @property int $status 上下架状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Product extends \backend\models\base\Shop
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'flagMark' => [
	            'class' => FlagBehavior::class,
	        ],
	        'parentCateParent' => [
	            'class' => ProductCateBehavior::class,
	        ],
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
	        ],
	        'promoteStartDate' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'promote_start_date',
	        ],
	        'promoteEndDate' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'promote_end_date',
	        ],
	        'picarr' => [
	            'class' => MultiPicBehavior::class,
	            'picsAttribute' => 'picarr',
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
        return '{{%shop_product}}';
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
        //静态默认值由规则来赋值
        return ArrayHelper::merge(DiyField::DiyFieldRule($this), [
            [['columnid', 'pcateid', 'brand_id', 'title', 'sales_price', 'content', 'picurl', 'slug'], 'required'],
            [['columnid', 'pcateid', 'brand_id', 'stock', 'hits', 'orderid', 'deltime', 'created_at', 'updated_at', 'promote_start_date', 'promote_end_date', 'posttime'], 'integer'],
            [['title', 'sku', 'picurl'], 'string', 'max' => 100],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['subtitle'], 'string', 'max' => 150],
            [['keywords', 'product_sn'], 'string', 'max' => 30],
            [['description', 'linkurl'], 'string', 'max' => 255],
            [['is_promote', 'is_shipping', 'is_best', 'is_new', 'is_hot', 'status'], 'string', 'max' => 1],
            [['attrtext', 'content', 'picarr', 'author', 'flag', 'slug'], 'string'],
            [['market_price', 'sales_price', 'promote_price', 'weight', 'delstate'], 'number'],
            
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['picarr'], 'default', 'value' => ''],
            [['weight', 'market_price'], 'default', 'value' => 0],
            [['stock'], 'default', 'value' => Yii::$app->params['config_stock_warning']],
            [['base_hits'], 'default', 'value' => Yii::$app->params['config.hits']],
            [['hits'], 'default', 'value' => 0],
            [['picarr', 'keyword'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(DiyField::DiyFieldRule($this, false), [
            'id' => 'ID',
            'columnid' => '所属栏目',
            'pcateid' => '商品分类',
            'attrtext' => '产品属性',
            'brand_id' => '商品品牌',
            'title' => '商品名称',
            'slug' => '访问链接',
            'colorval' => '标题颜色',
            'boldval' => '标题加粗',
            'subtitle' => '副标题',
            'keywords' => '关键词',
            'description' => '摘要',
            'flag' => '产品标签',
            'sku' => 'SKU',
            'product_sn' => '货号',
            'weight' => '重量',
            'market_price' => '市场价格',
            'sales_price' => '销售价格',
            'is_promote' => '是否促销',
            'promote_price' => '促销价',
            'promote_start_date' => '促销开始日期',
            'promote_end_date' => '促销结束日期',
            'stock' => '库存数量',
            'is_shipping' => '是否配送',
            'linkurl' => '跳转链接',
            'content' => '详细内容',
            'picurl' => '缩略图片',
            'picarr' => '组图',
            'is_best' => '是否最爱',
            'is_new' => '是否新品',
            'is_hot' => '是否最热',
            'base_hits' => '虚拟点击量',
            'hits' => '点击次数',
            'author' => '作者',
            'orderid' => '排序',
            'posttime' => '上架时间',
            'status' => '上下架状态',
            'delstate' => '删除状态',
            'deltime' => '删除时间',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ]);
    }
    
    /**
     * 最终交易价格
     */
    public function finalPrice()
    {
        $price = $this->sales_price;
        
        $time = time();
        if($this->is_promote && ($time > $this->promote_start_date && time() < $this->promote_end_date)) {
            $price = $this->promote_price;
        }
        
        return $price;
    }
    
    /**
     * 判断是否促销并自动修改状态
     */
    public function isPromote()
    {
        if($this->is_promote) {
            $time = time();
            if(($time < $this->promote_start_date || time() > $this->promote_end_date)) {
                //更新促销状态
                self::updateAll(['is_promote' => false], ['id' => $this->id]);
                return false;
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * 产品属性表单
     */
    public function attributeForm()
    {
        return ProductCate::AttributeForm($this->pcateid, $this->attrtext);
    }
    
    public function dealAttribute($post = [])
    {
        if(isset($post['pattribute'])) {
            self::updateAll(['attrtext' => Json::encode($post['pattribute'])], ['id' => $this->id]);
        }
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
