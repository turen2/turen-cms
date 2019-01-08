<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;

/**
 * This is the model class for table "{{%cms_file}}".
 *
 * @property string $id 软件信息id
 * @property string $columnid 所属栏目id
 * @property string $parentid 所属栏目上级id
 * @property string $parentstr 所属栏目上级id字符串
 * @property string $cateid 类别id
 * @property string $catepid 类别父id
 * @property string $catepstr 多级父id
 * @property string $title 标题
 * @property string $slug 访问链接
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $flag 属性
 * @property string $source 文章来源
 * @property string $author 作者编辑
 * @property string $filetype 文件类型
 * @property string $filesize 软件大小
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
 * @property int $posttime 更新时间
 * @property int $status 审核状态
 * @property int $delstate 删除状态
 * @property string $deltime 删除时间
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class File extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['columnid', 'parentid', 'parentstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'filetype', 'filesize', 'website', 'demourl', 'dlurl', 'linkurl', 'keywords', 'description', 'content', 'picurl', 'picarr', 'hits', 'orderid', 'posttime', 'deltime', 'lang'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['content', 'picarr'], 'string'],
            [['parentstr', 'catepstr', 'title'], 'string', 'max' => 80],
            [['slug'], 'string', 'max' => 200],
            [['colorval', 'boldval', 'filesize'], 'string', 'max' => 10],
            [['flag'], 'string', 'max' => 30],
            [['source', 'author', 'keywords'], 'string', 'max' => 50],
            [['filetype'], 'string', 'max' => 4],
            [['website', 'demourl', 'dlurl', 'linkurl', 'description'], 'string', 'max' => 255],
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
            'id' => Yii::t('app', '软件信息id'),
            'columnid' => Yii::t('app', '所属栏目id'),
            'parentid' => Yii::t('app', '所属栏目上级id'),
            'parentstr' => Yii::t('app', '所属栏目上级id字符串'),
            'cateid' => Yii::t('app', '类别id'),
            'catepid' => Yii::t('app', '类别父id'),
            'catepstr' => Yii::t('app', '多级父id'),
            'title' => Yii::t('app', '标题'),
            'slug' => Yii::t('app', '访问链接'),
            'colorval' => Yii::t('app', '字体颜色'),
            'boldval' => Yii::t('app', '字体加粗'),
            'flag' => Yii::t('app', '属性'),
            'source' => Yii::t('app', '文章来源'),
            'author' => Yii::t('app', '作者编辑'),
            'filetype' => Yii::t('app', '文件类型'),
            'filesize' => Yii::t('app', '软件大小'),
            'website' => Yii::t('app', '官方网站'),
            'demourl' => Yii::t('app', '演示地址'),
            'dlurl' => Yii::t('app', '下载地址'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'keywords' => Yii::t('app', '关键字'),
            'description' => Yii::t('app', '描述'),
            'content' => Yii::t('app', '内容'),
            'picurl' => Yii::t('app', '缩略图片'),
            'picarr' => Yii::t('app', '截图展示'),
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

    /**
     * {@inheritdoc}
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }
}
