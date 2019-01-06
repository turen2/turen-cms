<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;

/**
 * This is the model class for table "{{%cms_block}}".
 *
 * @property string $id 碎片数据id
 * @property string $title 碎片数据名称
 * @property string $picurl 碎片数据缩略图
 * @property string $linkurl 碎片数据连接
 * @property string $content 碎片数据内容
 * @property string $posttime 发布时间
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Block extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_block}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'picurl', 'linkurl', 'content', 'posttime', 'lang'], 'required'],
            [['content'], 'string'],
            [['posttime', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['picurl', 'linkurl'], 'string', 'max' => 80],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '碎片数据id'),
            'title' => Yii::t('app', '碎片数据名称'),
            'picurl' => Yii::t('app', '碎片数据缩略图'),
            'linkurl' => Yii::t('app', '碎片数据连接'),
            'content' => Yii::t('app', '碎片数据内容'),
            'posttime' => Yii::t('app', '发布时间'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlockQuery(get_called_class());
    }
}
