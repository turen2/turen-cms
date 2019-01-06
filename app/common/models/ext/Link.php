<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\ext;

use Yii;

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
 * @property string $posttime 更新时间
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Link extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link_type_id', 'parentid', 'parentstr', 'webname', 'webnote', 'picurl', 'linkurl', 'orderid', 'posttime', 'lang'], 'required'],
            [['link_type_id', 'parentid', 'orderid', 'posttime', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr'], 'string', 'max' => 80],
            [['webname'], 'string', 'max' => 30],
            [['webnote'], 'string', 'max' => 200],
            [['picurl'], 'string', 'max' => 100],
            [['linkurl'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '友情链接id'),
            'link_type_id' => Yii::t('app', '所属类别id'),
            'parentid' => Yii::t('app', '所属类别父id'),
            'parentstr' => Yii::t('app', '所属类别父id字符串'),
            'webname' => Yii::t('app', '网站名称'),
            'webnote' => Yii::t('app', '网站描述'),
            'picurl' => Yii::t('app', '缩略图片'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'orderid' => Yii::t('app', '排列排序'),
            'posttime' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '审核状态'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkQuery(get_called_class());
    }
}
