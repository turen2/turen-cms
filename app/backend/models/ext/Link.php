<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use app\behaviors\InsertLangBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\widgets\laydate\LaydateBehavior;

/**
 * This is the model class for table "{{%ext_link}}".
 *
 * @property string $id 友情链接id
 * @property string $link_type_id 所属类别id
 * @property string $parentid 所属类别父id
 * @property string $parentstr 所属类别父id字符串
 * @property string $webname 网站名称
 * @property string $webnote 网站描述
 * @property string $picurl 缩略图片
 * @property string $linkurl 跳转链接
 * @property string $orderid 排列排序
 * @property string $posttime 发布时间
 * @property int $status 显示状态
 * @property string $lang
 */
class Link extends \app\models\base\Ext
{
	public $keyword;
	
	private static $_linkTypeName;

	public function behaviors()
	{
	    return [
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
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
	    ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ext_link}}';
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
            [['link_type_id', 'webname'], 'required'],
            [['link_type_id', 'parentid', 'orderid'], 'integer'],
            [['parentstr'], 'string', 'max' => 80],
            [['webname'], 'string', 'max' => 30],
            [['webnote'], 'string', 'max' => 200],
            [['picurl'], 'string', 'max' => 100],
            [['linkurl'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
            [['posttime'], 'string'],
            
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
            'id' => '友情链接id',
            'link_type_id' => '所属链接组',
            'parentid' => '所属类别父id',
            'parentstr' => '所属类别父id字符串',
            'webname' => '网站名称',
            'webnote' => '网站描述',
            'picurl' => '缩略图片',
            'linkurl' => '跳转链接',
            'orderid' => '排列排序',
            'posttime' => '发布时间',
            'status' => '显示状态',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 获取所有分类名称
     * @return array|string|mixed
     */
    public function getLinkTypeName($isAll = false) {
        if(empty(self::$_linkTypeName)) {
            $arrLinkType = LinkType::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach ($arrLinkType as $type) {
                self::$_linkTypeName[$type['id']] = $type['typename'];
            }
        }
        
        if($isAll) {
            return self::$_linkTypeName;
        } else {
            return isset(self::$_linkTypeName[$this->link_type_id])?self::$_linkTypeName[$this->link_type_id]:'无分类';
        }
    }

    /**
     * @inheritdoc
     * @return LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkQuery(get_called_class());
    }
}
