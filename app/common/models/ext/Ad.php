<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\ext;

use common\helpers\ImageHelper;
use Yii;

/**
 * This is the model class for table "{{%ext_ad}}".
 *
 * @property string $id 信息id
 * @property string $ad_type_id 投放范围(广告位)
 * @property string $parentid 所属广告位父id
 * @property string $parentstr 所属广告位父id字符串
 * @property string $title 广告标识
 * @property string $admode 展示模式
 * @property string $picurl 上传内容地址
 * @property string $adtext 展示内容
 * @property string $linkurl 跳转链接
 * @property string $orderid 排列排序
 * @property string $posttime 提交时间
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Ad extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_ad}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ad_type_id', 'parentid', 'parentstr', 'title', 'admode', 'picurl', 'adtext', 'linkurl', 'orderid', 'posttime', 'lang'], 'required'],
            [['ad_type_id', 'parentid', 'orderid', 'posttime', 'status', 'created_at', 'updated_at'], 'integer'],
            [['adtext'], 'string'],
            [['parentstr'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 30],
            [['admode'], 'string', 'max' => 10],
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
            'id' => Yii::t('app', '信息id'),
            'ad_type_id' => Yii::t('app', '投放范围(广告位)'),
            'parentid' => Yii::t('app', '所属广告位父id'),
            'parentstr' => Yii::t('app', '所属广告位父id字符串'),
            'title' => Yii::t('app', '广告标识'),
            'admode' => Yii::t('app', '展示模式'),
            'picurl' => Yii::t('app', '上传内容地址'),
            'adtext' => Yii::t('app', '展示内容'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'orderid' => Yii::t('app', '排列排序'),
            'posttime' => Yii::t('app', '提交时间'),
            'status' => Yii::t('app', '审核状态'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * 返回广告图片地址
     * @return string
     */
    public function imageSrc()
    {
        return empty($this->picurl)?ImageHelper::getNopic():Yii::$app->aliyunoss->getObjectUrl($this->picurl, true);
    }

    /**
     * 通过广告位取出对应的广告列表
     * @param $adTypeId
     * @return array|\common\components\Column[]
     */
    public static function AdListByAdTypeId($adTypeId)
    {
        return self::find()->current()->active()->where(['ad_type_id' => $adTypeId])->orderBy(['orderid' => SORT_DESC])->asArray()->all();
    }

    /**
     * {@inheritdoc}
     * @return AdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdQuery(get_called_class());
    }
}
