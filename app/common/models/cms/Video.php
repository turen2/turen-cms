<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;

/**
 * This is the model class for table "{{%cms_video}}".
 *
 * @property string $id 视频信息id
 * @property string $columnid 所属栏目id
 * @property string $parentid 所属栏目上级id
 * @property string $parentstr 所属栏目上级id字符串
 * @property string $cateid 所属类别id
 * @property string $catepid 所属类别上级id
 * @property string $catepstr 所属类别上级id字符串
 * @property string $title 标题
 * @property string $slug 访问链接
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $flag 属性
 * @property string $source 文章来源
 * @property string $author 作者编辑
 * @property string $linkurl 跳转链接
 * @property string $keywords 关键词
 * @property string $description 摘要
 * @property string $content 详细内容
 * @property string $picurl 缩略视频
 * @property string $videolink 视频地址
 * @property string $hits 点击次数
 * @property string $orderid 排列排序
 * @property string $posttime 更新时间
 * @property int $status 审核状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 */
class Video extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_video}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['columnid', 'parentid', 'parentstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'linkurl', 'keywords', 'description', 'content', 'picurl', 'videolink', 'hits', 'orderid', 'posttime', 'deltime', 'lang'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['content', 'videolink'], 'string'],
            [['parentstr', 'catepstr', 'title'], 'string', 'max' => 80],
            [['slug'], 'string', 'max' => 200],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['flag'], 'string', 'max' => 30],
            [['source', 'author', 'keywords'], 'string', 'max' => 50],
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
            'id' => Yii::t('app', '视频信息id'),
            'columnid' => Yii::t('app', '所属栏目id'),
            'parentid' => Yii::t('app', '所属栏目上级id'),
            'parentstr' => Yii::t('app', '所属栏目上级id字符串'),
            'cateid' => Yii::t('app', '所属类别id'),
            'catepid' => Yii::t('app', '所属类别上级id'),
            'catepstr' => Yii::t('app', '所属类别上级id字符串'),
            'title' => Yii::t('app', '标题'),
            'slug' => Yii::t('app', '访问链接'),
            'colorval' => Yii::t('app', '字体颜色'),
            'boldval' => Yii::t('app', '字体加粗'),
            'flag' => Yii::t('app', '属性'),
            'source' => Yii::t('app', '文章来源'),
            'author' => Yii::t('app', '作者编辑'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'keywords' => Yii::t('app', '关键词'),
            'description' => Yii::t('app', '摘要'),
            'content' => Yii::t('app', '详细内容'),
            'picurl' => Yii::t('app', '缩略视频'),
            'videolink' => Yii::t('app', '视频地址'),
            'hits' => Yii::t('app', '点击次数'),
            'orderid' => Yii::t('app', '排列排序'),
            'posttime' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '审核状态'),
            'delstate' => Yii::t('app', '删除状态'),
            'deltime' => Yii::t('app', '删除时间'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
    }
}