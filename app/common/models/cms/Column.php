<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;

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
class Column extends \app\components\ActiveRecord
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
     * {@inheritdoc}
     * @return ColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColumnQuery(get_called_class());
    }
}
