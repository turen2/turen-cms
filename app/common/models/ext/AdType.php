<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\ext;

use Yii;

/**
 * This is the model class for table "{{%ext_ad_type}}".
 *
 * @property string $id 广告位id
 * @property string $parentid 上级id
 * @property string $parentstr 上级id字符串
 * @property string $typename 广告位名称
 * @property int $width 广告位宽度
 * @property int $height 广告位高度
 * @property string $orderid 排列顺序
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class AdType extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_ad_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'parentstr', 'typename', 'orderid', 'lang'], 'required'],
            [['parentid', 'width', 'height', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr'], 'string', 'max' => 50],
            [['typename'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '广告位id'),
            'parentid' => Yii::t('app', '上级id'),
            'parentstr' => Yii::t('app', '上级id字符串'),
            'typename' => Yii::t('app', '广告位名称'),
            'width' => Yii::t('app', '广告位宽度'),
            'height' => Yii::t('app', '广告位高度'),
            'orderid' => Yii::t('app', '排列顺序'),
            'status' => Yii::t('app', '审核状态'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdTypeQuery(get_called_class());
    }
}
