<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use app\behaviors\InsertLangBehavior;
use yii\db\ActiveRecord;
use app\widgets\select2\TaggableBehavior;
use app\widgets\laydate\LaydateBehavior;
use app\widgets\fileupload\MultiPicBehavior;
use app\widgets\diyfield\DiyFieldBehavior;
use app\behaviors\FlagBehavior;
use app\behaviors\CateBehavior;
use app\behaviors\ColumnBehavior;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%cms_article}}".
 *
 * @property string $id 列表信息id
 * @property int $columnid 所属栏目id
 * @property int $cateid 类别id
 * @property int $parentid 所属栏目上级id
 * @property string $parentstr 所属栏目上级id字符串
 * @property string $title 标题
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $flag 属性
 * @property string $source 信息来源
 * @property string $author 作者编辑
 * @property string $linkurl 跳转链接
 * @property string $keywords 关键词
 * @property string $description 摘要
 * @property string $content 详细内容
 * @property string $picurl 缩略图片
 * @property string $picarr 组图
 * @property string $hits 点击次数
 * @property string $orderid 排列排序
 * @property int $posttime 发布时间
 * @property int $status 审核状态
 * @property string $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang
 */
class Article extends \app\models\base\Cms
{
	public $keyword;

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
	        'taggabble' => TaggableBehavior::class,//tags
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
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
        return '{{%cms_article}}';
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
        return ArrayHelper::merge(DiyField::DiyFieldRule($this), [
            [['columnid', 'title'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'deltime', 'delstate', 'status', 'posttime'], 'integer'],
            [['parentstr', 'catepstr', 'title'], 'string', 'max' => 80],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['source', 'keywords'], 'string', 'max' => 50],
            [['linkurl', 'description'], 'string', 'max' => 255],
            [['content', 'picurl', 'lang', 'flag'], 'string'],
            [['author'], 'default', 'value' => $this->getAdmin()->username],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['picarr'], 'default', 'value' => ''],
            [['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
            [['tagNames', 'picarr'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(DiyField::DiyFieldRule($this, false), [
            'id' => '列表信息ID',
            'columnid' => '所属栏目',
            'cateid' => '所属类别',
            'title' => '文章标题',
            'colorval' => '字体颜色',
            'boldval' => '字体加粗',
            'flag' => '展示标记',
            'tags' => '标签',
            'source' => '信息来源',
            'author' => '作者编辑',
            'linkurl' => '跳转链接',
            'keywords' => 'SEO关键词',
            'description' => 'SEO摘要',
            'content' => '详细内容',
            'picurl' => '缩略图片',
            'picarr' => '组图',
            'hits' => '点击次数',
            'orderid' => '排列排序',
            'posttime' => '发布时间',
            'status' => '审核状态',
            'delstate' => '删除状态',
            'deltime' => '删除时间',
            'lang' => '语言',
        ]);
    }
    
    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
