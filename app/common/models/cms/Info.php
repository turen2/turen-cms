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
 * This is the model class for table "{{%cms_info}}".
 *
 * @property string $id 单页id
 * @property string $columnid 所属栏目id
 * @property string $slug 链接别名
 * @property string $picurl 缩略图片
 * @property string $content 内容
 * @property string $posttime 发布时间
 */
class Info extends \common\components\ActiveRecord
{
    public $title;
    public $parentstr;

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
     * @return mixed
     */
    public static function ActiveList($className, $columnId, $listNum = null, $flag = null)
    {
        $model = new self();
        return $model->columnList($className, $columnId, $listNum, $flag);//以行为绑定的方式，实现静态调用，实现方法重用
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_info}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['columnid', 'picurl', 'content', 'posttime'], 'required'],
            [['columnid', 'posttime'], 'integer'],
            [['content'], 'string'],
            [['slug'], 'string', 'max' => 200],
            [['picurl'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '单页id'),
            'columnid' => Yii::t('app', '所属栏目id'),
            'slug' => Yii::t('app', '链接别名'),
            'picurl' => Yii::t('app', '缩略图片'),
            'content' => Yii::t('app', '内容'),
            'posttime' => Yii::t('app', '发布时间'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return InfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InfoQuery(get_called_class());
    }
}
