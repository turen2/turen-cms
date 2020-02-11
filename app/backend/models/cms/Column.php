<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use backend\behaviors\InsertLangBehavior;
use backend\models\shop\Product;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%cms_column}}".
 *
 * @property int $id 栏目id

 * @property int $parentid 栏目上级id
 * @property string $parentstr 栏目上级id字符串
 * @property int $type 栏目类型
 * @property string $cname 栏目名称
 * @property string $linkurl 跳转链接
 * @property string $picurl 缩略图片
 * @property string $picwidth 缩略图宽度
 * @property string $picheight 缩略图高度
 * @property string $seotitle SEO标题
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property int $orderid 排列排序
 * @property int $status 审核状态
 * @property string $lang
 */
class Column extends \backend\models\base\Cms
{
    //栏目类型
    const COLUMN_TYPE_CATE = 100;//栏目总类别
    const COLUMN_TYPE_ARTICLE = 1;
    const COLUMN_TYPE_PHOTO = 2;
    const COLUMN_TYPE_FILE = 3;
    const COLUMN_TYPE_PRODUCT = 4;
    const COLUMN_TYPE_VIDEO = 5;
    const COLUMN_TYPE_INFO = 6;

    const COLUMN_CONVERT_ALL = 'COLUMN_CONVERT_ALL';
    
	public $keyword;
	
	public $level;
	
	private static $_allColumn;
	
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
        return '{{%cms_column}}';
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
            [['parentid', 'type', 'cname'], 'required'],
            [['parentid', 'orderid'], 'integer'],
            [['parentstr', 'keywords'], 'string', 'max' => 50],
            [['type', 'status'], 'string', 'max' => 3],
            [['cname'], 'string', 'max' => 30],
            [['linkurl', 'description'], 'string', 'max' => 255],
            [['picurl'], 'string', 'max' => 100],
            [['picwidth', 'picheight'], 'string', 'max' => 5],
            [['seotitle'], 'string', 'max' => 80],
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
        $children = Column::find()->select('id')->current()->where(['like', 'parentstr', ','.$this->id.','])->asArray()->all();
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
            'id' => '栏目ID',
            'parentid' => '所属栏目',
            'parentstr' => '栏目上级ID字符串',
            'type' => '栏目类型',
            'cname' => '栏目名称',
            'linkurl' => '跳转链接',
            'picurl' => '缩略图片',
            'picwidth' => '宽度(px)',
            'picheight' => '高度(px)',
            'seotitle' => 'SEO标题',
            'keywords' => '关键词',
            'description' => '栏目描述',
            'orderid' => '排列排序',
            'status' => '栏目状态',
            'lang' => '语言',
        ];
    }

    /**
     * 转换器
     * 负责模型类、栏目、ID、名称、标记之间的转换
     * @param $pattern
     * @param mixed | null |  $key
     * @param string $default
     * @return array|mixed|string
     * @throws InvalidConfigException
     *
     * $pattern：
     * 'id2name' ID对应名称
     * 'id2mask' ID对应标记
     * 'id2class' ID对应模型类
     * 'mask2id' 标记对应ID
     * 'class2id' 模型类对应ID
     * 'class2name' 模型类对应类名
     * .....
     * $key：
     * 转化后获取其中一个值的时候所使用的键//不可以mask2id、mask2class、mask2name
     * return [] | int | string
     */
    public static function ColumnConvert($pattern, $key = self::COLUMN_CONVERT_ALL, $default = '')
    {
        $data = [
            self::COLUMN_TYPE_CATE => [
                'id' => self::COLUMN_TYPE_CATE,
                'class' => \stdClass::class,
                'name' => '栏目类别',
                'mask' => 'cate',
            ],
            self::COLUMN_TYPE_INFO => [
                'id' => self::COLUMN_TYPE_INFO,
                'class' => Info::class,
                'name' => '单页',
                'mask' => 'info',
            ],
            self::COLUMN_TYPE_ARTICLE => [
                'id' => self::COLUMN_TYPE_ARTICLE,
                'class' => Article::class,
                'name' => '列表',
                'mask' => 'article',
            ],
            self::COLUMN_TYPE_PHOTO => [
                'id' => self::COLUMN_TYPE_PHOTO,
                'class' => Photo::class,
                'name' => '图片',
                'mask' => 'photo',
            ],
            self::COLUMN_TYPE_FILE => [
                'id' => self::COLUMN_TYPE_FILE,
                'class' => File::class,
                'name' => '下载',
                'mask' => 'file',
            ],
            self::COLUMN_TYPE_PRODUCT => [
                'id' => self::COLUMN_TYPE_PRODUCT,
                'class' => Product::class,
                'name' => '产品',
                'mask' => 'product',
            ],
            self::COLUMN_TYPE_VIDEO => [
                'id' => self::COLUMN_TYPE_VIDEO,
                'class' => Video::class,
                'name' => '视频',
                'mask' => 'video',
            ],
        ];
        
        foreach (DiyModel::find()->active()->asArray()->all() as $diymodel) {
            $data[$diymodel['dm_id']] = [
                'id' => $diymodel['dm_id'],
                'class' => MasterModel::class.'_'.$diymodel['dm_id'],//母模型会有重叠，因为使用id区分
                'name' => $diymodel['dm_title'],
                'mask' => 'master-model',//不可以mask2id、mask2class、mask2name
            ];
        }
        
        //匹配需要的类型数组
        list($k, $v) = explode('2', strtolower($pattern));
        if(in_array($k, ['id', 'class', 'name', 'mask']) && in_array($v, ['id', 'class', 'name', 'mask'])) {
            $list = [];
            foreach ($data as $dd) {
                $list[$dd[$k]] = $dd[$v];
            }

            //是否获取一个元素，否则返回整个'未定义'
            if(is_null($key)) {
                return '未定义';
            } elseif($key === self::COLUMN_CONVERT_ALL) {
                return $list;
            } else {
                return isset($list[$key])?$list[$key]:$default;
            }
        } else {
            //异常
            throw new InvalidConfigException(Column::class.'参数错误，参数为：'.$pattern);
        }
    }

    /**
     * 获取栏目路由链接
     * @param $key
     * @param Column $model
     * @return string
     * @throws InvalidConfigException
     */
    public static function ColumnLinkList($key, Column $model)
    {
        $mask = self::ColumnConvert('id2mask', $key);
        
        if(!empty($mask)) {
            if($key == self::COLUMN_TYPE_INFO) {
                return Url::to(['info/update', 'id' => $model->id]);
            } elseif($key == self::COLUMN_TYPE_PRODUCT) {
                return Url::to(['/shop/product/create', 'columnid' => $model->id]);
            } elseif(DiyModel::find()->where(['dm_id' => $key])->exists()) {
                return Url::to([$mask.'/create', 'mid' => $key, 'columnid' => $model->id]);
            } else {
                return Url::to([$mask.'/create', 'columnid' => $model->id]);
            }
        } else {
            return '';
        }
    }
    
    /**
     * 创建之后，如果是单页面类型，则对应创建单页面
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($this->type == self::COLUMN_TYPE_INFO) {
            if($insert) {
                $model = new Info();
                $model->columnid = $this->id;
                $model->save(false);
            } else {//更新时检测
                $model = Info::find()->where(['columnid' => $this->id])->one();
                if(empty($model)) {
                    $model = new Info();
                    $model->columnid = $this->id;
                    $model->save(false);
                }
            }
        }
    }
    
    /**
     * 获取所有栏目列表
     * @param integer $columnid 栏目id
     * @return array
     */
    public static function ColumnList() {
        //使用频繁，初始化载入
        if(empty(self::$_allColumn)) {
            self::$_allColumn = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach (self::$_allColumn as $column) {
                self::$_allColumn[$column['id']] = $column;
            }
        }
        
        return self::$_allColumn;
    }
    
    /**
     * 获取指定类型的栏目列表
     * @param integer $type
     * @return array
     */
    public static function ColumnListByType($type) {
        $columnList = self::ColumnList();
        foreach ($columnList as $key => $column) {
            if($column['type'] != $type) {
                unset($columnList[$key]);
            }
        }
        
        return $columnList;
    }
    
    /**
     * 获取栏目名称
     * @param unknown $columnid
     * @return string|string|mixed
     */
    public static function ColumnName($columnid)
    {
        $name = '未定义';
        $columnList = self::ColumnList();
        if(is_null($columnid)) {
            return $name;
        } else {
            return isset($columnList[$columnid])?$columnList[$columnid]['cname']:$name;
        }
    }
    /**
     * 删除之后，如果是单页面类型，对应删除
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterDelete()
     */
    public function afterDelete()
    {
        if($this->type == self::COLUMN_TYPE_INFO) {
            $model = Info::find()->where(['columnid' => $this->id])->one();
            if($model)
                $model->delete();
        }
    }

    /**
     * @inheritdoc
     * @return ColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColumnQuery(get_called_class());
    }
}
