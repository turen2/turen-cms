<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use common\behaviors\ListBehavior;
use Yii;

/**
 * This is the model class for table "{{%cms_article}}".
 *
 * @property string $id 列表信息id
 * @property string $columnid 所属栏目id
 * @property string $parentid 所属栏目上级id
 * @property string $parentstr 所属栏目上级id字符串
 * @property string $cateid 类别id
 * @property string $catepid 类别父id
 * @property string $catepstr 所属类别上级id字符串
 * @property string $title 标题
 * @property string $slug 链接别名
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $flag 属性
 * @property string $source 文章来源
 * @property string $author 作者编辑
 * @property string $linkurl 跳转链接
 * @property string $keywords 关键词
 * @property string $description 摘要
 * @property string $content 详细内容
 * @property string $picurl 缩略图片
 * @property string $picarr 组图
 * @property string $hits 点击次数
 * @property string $orderid 排列排序
 * @property int $posttime 更新时间
 * @property int $status 审核状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Article extends \common\components\ActiveRecord
{
    public function behaviors()
    {
        return [
            'activeList' => [
                'class' => ListBehavior::class,//动态绑定一个静态方法
            ],
        ];
    }

    /**
     * 根据参数，返回栏目内容
     * @param $className cms栏目类
     * @param $columnId 栏目id
     * @param null $listNum 限定返回的数量
     * @param null $flag 指定标识
     * @param null $torder 指定时间排序，默认为orderid排序
     * @return mixed
     */
    public static function ActiveList($className, $columnId, $listNum = null, $flag = null, $torder = null)
    {
        $model = new self();
        return $model->columnList($className, $columnId, $listNum, $flag, $torder);//以行为绑定的方式，实现静态调用，实现方法重用
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['columnid', 'parentid', 'parentstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'linkurl', 'keywords', 'description', 'content', 'picurl', 'picarr', 'hits', 'orderid', 'posttime', 'deltime', 'lang'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['content', 'picarr'], 'string'],
            [['parentstr', 'catepstr', 'title'], 'string', 'max' => 80],
            [['slug'], 'string', 'max' => 200],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['flag'], 'string', 'max' => 30],
            [['source', 'author'], 'string', 'max' => 50],
            [['keywords'], 'string', 'max' => 100],
            [['linkurl', 'description'], 'string', 'max' => 255],
            [['picurl'], 'string', 'max' => 100],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '列表信息id'),
            'columnid' => Yii::t('app', '所属栏目id'),
            'parentid' => Yii::t('app', '所属栏目上级id'),
            'parentstr' => Yii::t('app', '所属栏目上级id字符串'),
            'cateid' => Yii::t('app', '类别id'),
            'catepid' => Yii::t('app', '类别父id'),
            'catepstr' => Yii::t('app', '所属类别上级id字符串'),
            'title' => Yii::t('app', '标题'),
            'slug' => Yii::t('app', '链接别名'),
            'colorval' => Yii::t('app', '字体颜色'),
            'boldval' => Yii::t('app', '字体加粗'),
            'flag' => Yii::t('app', '属性'),
            'source' => Yii::t('app', '文章来源'),
            'author' => Yii::t('app', '作者编辑'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'keywords' => Yii::t('app', '关键词'),
            'description' => Yii::t('app', '摘要'),
            'content' => Yii::t('app', '详细内容'),
            'picurl' => Yii::t('app', '缩略图片'),
            'picarr' => Yii::t('app', '组图'),
            'hits' => Yii::t('app', '点击次数'),
            'orderid' => Yii::t('app', '排列排序'),
            'posttime' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '审核状态'),
            'delstate' => Yii::t('app', '删除状态'),
            'deltime' => Yii::t('app', '删除时间'),
            'lang' => Yii::t('app', 'Lang'),
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
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
