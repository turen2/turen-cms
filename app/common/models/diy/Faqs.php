<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\diy;

use Yii;

/**
 * This is the model class for table "{{%diymodel_faqs}}".
 *
 * @property string $id ID
 * @property string $title 标题
 * @property string $slug 访问链接
 * @property string $colorval 字体颜色
 * @property string $boldval 字体加粗
 * @property string $columnid 栏目ID
 * @property string $parentid 栏目父ID
 * @property string $parentstr 栏目父ID列表
 * @property string $cateid 类别ID
 * @property string $catepid 类别父ID
 * @property string $catepstr 类别父ID列表
 * @property string $flag 标记
 * @property string $picurl 缩略图
 * @property string $lang 多语言
 * @property int $status 状态
 * @property string $orderid 排序
 * @property string $posttime 发布时间
 * @property string $updated_at 更新时间
 * @property string $created_at 添加时间
 * @property string $diyfield_ask_content
 */
class Faqs extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diymodel_faqs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['colorval', 'boldval', 'columnid', 'parentid', 'parentstr'], 'required'],
            [['columnid', 'parentid', 'cateid', 'catepid', 'status', 'orderid', 'posttime', 'updated_at', 'created_at'], 'integer'],
            [['diyfield_ask_content'], 'string'],
            [['title', 'parentstr', 'catepstr'], 'string', 'max' => 80],
            [['slug'], 'string', 'max' => 200],
            [['colorval', 'boldval'], 'string', 'max' => 10],
            [['flag'], 'string', 'max' => 30],
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
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'slug' => Yii::t('app', '访问链接'),
            'colorval' => Yii::t('app', '字体颜色'),
            'boldval' => Yii::t('app', '字体加粗'),
            'columnid' => Yii::t('app', '栏目ID'),
            'parentid' => Yii::t('app', '栏目父ID'),
            'parentstr' => Yii::t('app', '栏目父ID列表'),
            'cateid' => Yii::t('app', '类别ID'),
            'catepid' => Yii::t('app', '类别父ID'),
            'catepstr' => Yii::t('app', '类别父ID列表'),
            'flag' => Yii::t('app', '标记'),
            'picurl' => Yii::t('app', '缩略图'),
            'lang' => Yii::t('app', '多语言'),
            'status' => Yii::t('app', '状态'),
            'orderid' => Yii::t('app', '排序'),
            'posttime' => Yii::t('app', '发布时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'created_at' => Yii::t('app', '添加时间'),
            'diyfield_ask_content' => Yii::t('app', '问答内容'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return FaqsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaqsQuery(get_called_class());
    }
}
