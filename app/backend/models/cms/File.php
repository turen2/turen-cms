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
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\widgets\select2\TaggableBehavior;
use app\widgets\laydate\LaydateBehavior;
use app\widgets\fileupload\MultiPicBehavior;
use app\widgets\diyfield\DiyFieldBehavior;
use app\behaviors\FlagBehavior;
use app\behaviors\CateBehavior;
use app\behaviors\ColumnBehavior;

/**
 * This is the model class for table "{{%cms_file}}".
 *
 * @property string $id 文件信息id
 * @property string $columnid 所属栏目id
 * @property int $cateid 类别id
 * @property string $parentid 所属栏目上级id
 * @property string $parentstr 所属栏目上级id字符串
 * @property string $cateid 类别id
 * @property string $catepid 类别父id
 * @property string $catepstr 多级父id
 * @property string $title 标题
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $flag 属性
 * @property string $source 信息来源
 * @property string $author 作者编辑
 * @property string $filetype 文件类型
 * @property string $filesize 文件大小
 * @property string $website 官方网站
 * @property string $demourl 演示地址
 * @property string $dlurl 下载地址
 * @property string $linkurl 跳转链接
 * @property string $keywords 关键字
 * @property string $description 描述
 * @property string $content 内容
 * @property string $picurl 缩略图片
 * @property string $picarr 截图展示
 * @property string $hits 点击次数
 * @property string $orderid 排列排序
 * @property int $posttime 发布时间
 * @property int $status 审核状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang
 */
class File extends \app\models\base\Cms
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
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'orderid',
	                //ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
	            ],
	            'value' => function ($event) {
    	            if(empty($this->orderid)) {
    	                $maxModel = self::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
    	                if($maxModel) {
    	                    return $maxModel->orderid + 1;
    	                } else {
    	                    return Yii::$app->params['config.orderid'];//配置默认值
    	                }
    	            }
    	            
    	            return $this->orderid;
	            }
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
        return '{{%cms_file}}';
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
            [['columnid', 'title', 'dlurl'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'deltime', 'delstate', 'posttime'], 'integer'],
            [['content', 'flag'], 'string'],
            [['parentstr', 'catepstr', 'title'], 'string', 'max' => 80],
            [['colorval', 'boldval', 'filesize'], 'string', 'max' => 10],
            [['source', 'author', 'keywords'], 'string', 'max' => 50],
            [['filetype'], 'string', 'max' => 4],
            [['website', 'demourl', 'dlurl', 'linkurl', 'description'], 'string', 'max' => 255],
            [['picurl'], 'string', 'max' => 100],
            [['lang'], 'string', 'max' => 8],
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
            'id' => '文件信息ID',
            'columnid' => '所属栏目',
            'cateid' => '所属类别',
            'parentid' => '所属栏目上级ID',
            'parentstr' => '所属栏目上级ID字符串',
            'cateid' => '所属类别',
            'catepid' => '类别父ID',
            'catepstr' => '多级父ID',
            'title' => '下载文件标题',
            'colorval' => '字体颜色',
            'boldval' => '字体加粗',
            'flag' => '展示标记',
            'tags' => '标签',
            'source' => '信息来源',
            'author' => '作者编辑',
            'filetype' => '文件类型',
            'filesize' => '文件大小',
            'website' => '官方网站',
            'demourl' => '演示地址',
            'dlurl' => '下载地址',
            'linkurl' => '跳转链接',
            'keywords' => 'SEO关键字',
            'description' => 'SEO描述',
            'content' => '内容',
            'picurl' => '截图封面',
            'picarr' => '多截图展示',
            'hits' => '点击次数',
            'orderid' => '排列排序',
            'posttime' => '发布时间',
            'status' => '审核状态',
            'delstate' => '删除状态',
            'deltime' => '删除时间',
            'lang' => '多语言',
        ]);
    }
    
    /**
     * @inheritdoc
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }
}
