<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;

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
 */
class Block extends \backend\models\base\Cms
{
	public $keyword;

	public function behaviors()
	{
	    return [
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
	        ],
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        //动态值由此属性行为处理
	        'defaultPosttime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'posttime',
	            'updatedAtAttribute' => false,
	        ],
	    ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_block}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), ['keyword']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 30],
            [['picurl', 'linkurl'], 'string', 'max' => 80],
            [['lang'], 'string', 'max' => 8],
            [['posttime'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '数据ID',
            'title' => '名称',
            'picurl' => '缩略图',
            'linkurl' => '外部链接',
            'content' => '内容',
            'posttime' => '发布时间',
            'lang' => '多语言',
        ];
    }

    /**
     * @inheritdoc
     * @return BlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlockQuery(get_called_class());
    }
}
