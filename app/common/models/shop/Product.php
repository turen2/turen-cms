<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\shop;

use common\models\cms\Column;
use Yii;

/**
 * This is the model class for table "{{%shop_product}}".
 *
 * @property string $id 商品id
 * @property string $columnid 所属栏目
 * @property string $pcateid 产品分类id
 * @property string $pcatepid 产品分类父id
 * @property string $pcatepstr 所有产品分类的上级id字符串
 * @property string $attrtext 属性json值
 * @property int $brand_id 商品品牌id
 * @property string $title 商品名称
 * @property string $slug 访问链接
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
 * @property int $warn_num 警告数量，如果为0则不警告
 * @property int $is_shipping 是否配送
 * @property int $point 返点积分
 * @property string $linkurl 跳转链接
 * @property string $content 详细内容
 * @property string $picurl 缩略图片
 * @property string $picarr 组图
 * @property int $is_best 最爱
 * @property int $is_new 新品
 * @property int $is_hot 最热
 * @property string $hits 点击次数
 * @property string $author
 * @property string $orderid 排列排序
 * @property string $posttime 上架时间
 * @property int $status 上下架状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang 多语言
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Product extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['columnid', 'pcateid', 'pcatepid', 'pcatepstr', 'attrtext', 'brand_id', 'title', 'colorval', 'boldval', 'keywords', 'description', 'flag', 'weight', 'market_price', 'sales_price', 'stock', 'linkurl', 'content', 'picurl', 'picarr', 'hits', 'orderid', 'posttime', 'lang'], 'required'],
            [['columnid', 'pcateid', 'pcatepid', 'brand_id', 'is_promote', 'promote_start_date', 'promote_end_date', 'stock', 'warn_num', 'is_shipping', 'point', 'is_best', 'is_new', 'is_hot', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['attrtext', 'content', 'picarr'], 'string'],
            [['weight', 'market_price', 'sales_price', 'promote_price'], 'number'],
            [['pcatepstr'], 'string', 'max' => 80],
            [['title', 'sku', 'picurl'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 200],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['subtitle'], 'string', 'max' => 150],
            [['flag', 'product_sn'], 'string', 'max' => 30],
            [['keywords'], 'string', 'max' => 100],
            [['description', 'linkurl'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '商品id'),
            'columnid' => Yii::t('app', '所属栏目'),
            'pcateid' => Yii::t('app', '产品分类id'),
            'pcatepid' => Yii::t('app', '产品分类父id'),
            'pcatepstr' => Yii::t('app', '所有产品分类的上级id字符串'),
            'attrtext' => Yii::t('app', '属性json值'),
            'brand_id' => Yii::t('app', '商品品牌id'),
            'title' => Yii::t('app', '商品名称'),
            'slug' => Yii::t('app', '访问链接'),
            'colorval' => Yii::t('app', '标题颜色'),
            'boldval' => Yii::t('app', '标题加粗'),
            'subtitle' => Yii::t('app', '副标题'),
            'keywords' => Yii::t('app', '关键词'),
            'description' => Yii::t('app', '摘要'),
            'flag' => Yii::t('app', '属性'),
            'sku' => Yii::t('app', '产品SKU'),
            'product_sn' => Yii::t('app', '货号'),
            'weight' => Yii::t('app', '重量'),
            'market_price' => Yii::t('app', '市场价格'),
            'sales_price' => Yii::t('app', '销售价格'),
            'is_promote' => Yii::t('app', '是否促销'),
            'promote_price' => Yii::t('app', '促销价'),
            'promote_start_date' => Yii::t('app', '促销开始日期'),
            'promote_end_date' => Yii::t('app', '促销结束日期'),
            'stock' => Yii::t('app', '库存数量'),
            'warn_num' => Yii::t('app', '警告数量，如果为0则不警告'),
            'is_shipping' => Yii::t('app', '是否配送'),
            'point' => Yii::t('app', '返点积分'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'content' => Yii::t('app', '详细内容'),
            'picurl' => Yii::t('app', '缩略图片'),
            'picarr' => Yii::t('app', '组图'),
            'is_best' => Yii::t('app', '最爱'),
            'is_new' => Yii::t('app', '新品'),
            'is_hot' => Yii::t('app', '最热'),
            'hits' => Yii::t('app', '点击次数'),
            'author' => Yii::t('app', 'Author'),
            'orderid' => Yii::t('app', '排列排序'),
            'posttime' => Yii::t('app', '上架时间'),
            'status' => Yii::t('app', '上下架状态'),
            'delstate' => Yii::t('app', '删除状态'),
            'deltime' => Yii::t('app', '删除时间'),
            'lang' => Yii::t('app', '多语言'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    public function getColumn()
    {
        return $this->hasOne(Column::class, ['id' => 'columnid']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
