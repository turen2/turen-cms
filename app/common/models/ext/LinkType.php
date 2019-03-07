<?php

namespace common\models\ext;

use Yii;

/**
 * This is the model class for table "{{%ext_link_type}}".
 *
 * @property string $id 友情链接类型id
 * @property string $parentid 类别父id
 * @property string $parentstr 类别父id字符串
 * @property string $typename 类别名称
 * @property string $orderid 排列顺序
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class LinkType extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_link_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'parentstr', 'typename', 'orderid', 'lang'], 'required'],
            [['parentid', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'id' => '友情链接类型id',
            'parentid' => '类别父id',
            'parentstr' => '类别父id字符串',
            'typename' => '类别名称',
            'orderid' => '排列顺序',
            'status' => '审核状态',
            'lang' => 'Lang',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LinkTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinkTypeQuery(get_called_class());
    }
}
