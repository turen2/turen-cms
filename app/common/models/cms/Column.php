<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use common\models\shop\Product;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%cms_column}}".
 *
 * @property string $id 栏目id
 * @property string $parentid 栏目上级id
 * @property string $parentstr 栏目上级id字符串
 * @property int $type 栏目类型
 * @property string $cname 栏目名称
 * @property string $linkurl 跳转链接
 * @property string $picurl 缩略图片
 * @property string $picwidth 缩略图宽度
 * @property string $picheight 缩略图高度
 * @property string $seotitle SEO标题
 * @property string $keywords SEO关键词
 * @property string $description SEO描述
 * @property string $orderid 排列排序
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Column extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_column}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'parentstr', 'type', 'cname', 'linkurl', 'picurl', 'picwidth', 'picheight', 'seotitle', 'keywords', 'description', 'orderid', 'lang'], 'required'],
            [['parentid', 'type', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr', 'keywords'], 'string', 'max' => 50],
            [['cname'], 'string', 'max' => 30],
            [['linkurl', 'description'], 'string', 'max' => 255],
            [['picurl'], 'string', 'max' => 100],
            [['picwidth', 'picheight'], 'string', 'max' => 5],
            [['seotitle'], 'string', 'max' => 80],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '栏目id'),
            'parentid' => Yii::t('app', '栏目上级id'),
            'parentstr' => Yii::t('app', '栏目上级id字符串'),
            'type' => Yii::t('app', '栏目类型'),
            'cname' => Yii::t('app', '栏目名称'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'picurl' => Yii::t('app', '缩略图片'),
            'picwidth' => Yii::t('app', '缩略图宽度'),
            'picheight' => Yii::t('app', '缩略图高度'),
            'seotitle' => Yii::t('app', 'SEO标题'),
            'keywords' => Yii::t('app', 'SEO关键词'),
            'description' => Yii::t('app', 'SEO描述'),
            'orderid' => Yii::t('app', '排列排序'),
            'status' => Yii::t('app', '审核状态'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * 转换器
     * 负责模型类、栏目、ID、名称、标记之间的转换
     * @param string $type
     * 'id2name' ID对应名称
     * 'id2mask' ID对应标记
     * 'id2class' ID对应模型类
     * 'mask2id' 标记对应ID
     * 'class2id' 模型类对应ID
     * 'class2name' 模型类对应类名
     * .....
     * @param $key 转化后获取其中一个值的时候所使用的键//不可以mask2id、mask2class、mask2name
     * return [] | int | string
     */
    public static function ColumnConvert($type, $key = null, $default = '')
    {
        $data = [
            [
                'class' => Info::class,
                'name' => '单页',
                'mask' => 'info',
            ],
            [
                'class' => Article::class,
                'name' => '列表',
                'mask' => 'article',
            ],
            [
                'class' => Photo::class,
                'name' => '图片',
                'mask' => 'photo',
            ],
            [
                'class' => File::class,
                'name' => '下载',
                'mask' => 'file',
            ],
            [
                'class' => Product::class,
                'name' => '产品',
                'mask' => 'product',
            ],
            [
                'class' => Video::class,
                'name' => '视频',
                'mask' => 'video',
            ],
        ];

        //匹配需要的类型数组
        list($k, $v) = explode('2', strtolower($type));
        if(in_array($k, ['class', 'name', 'mask']) && in_array($v, ['class', 'name', 'mask'])) {
            $list = [];
            foreach ($data as $dd) {
                $list[$dd[$k]] = $dd[$v];
            }

            //是否获取一个元素，否则返回整个数组
            if(is_null($key)) {
                return $list;
            } else {
                return isset($list[$key])?$list[$key]:$default;
            }
        } else {
            //异常
            throw new InvalidConfigException(Column::class.'参数错误，参数为：'.$type);
        }
    }

    /**
     * 栏目列表的面包屑数据
     */
    public static function Breadcrumbs($columnModel, $route = ['/'])
    {
        $links[] = ['label' => '<span>&gt;</span>'];

        $ids = [];
        if($columnModel) {
            $ids = explode(',', $columnModel->parentstr);
            array_pop($ids);
        }

        $columnModels = Column::findAll(['id' => $ids]);
        foreach ($columnModels as $cModel) {
            $links[] = ['label' => $cModel->cname, 'url' => ArrayHelper::merge($route, ['columnid' => $cModel->id])];
            $links[] = ['label' => '<span>&gt;</span>'];
        }

        $links[] =  $columnModel->cname.'列表';

        return $links;
    }

    /**
     * {@inheritdoc}
     * @return ColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColumnQuery(get_called_class());
    }
}
