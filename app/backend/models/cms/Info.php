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
use backend\widgets\laydate\LaydateBehavior;
use backend\widgets\diyfield\DiyFieldBehavior;

/**
 * This is the model class for table "{{%cms_info}}".
 *
 * @property int $id 单页id
 * @property int $columnid 所属栏目id
 * @property string $slug 访问链接
 * @property string $picurl 缩略图片
 * @property string $content 内容
 * @property string $posttime 发布时间
 */
class Info extends \backend\models\base\Cms
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'posttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'posttime',
	        ],
	        //动态值由此属性行为处理
	        'defaultPosttime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'posttime',
	            'updatedAtAttribute' => false,
	        ],
	        //自定义字段
	        'diyField' => [
	            'class' => DiyFieldBehavior::class,
	        ],
        ];
	}
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_info}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), ['cname', 'cid', 'pc_column', 'm_column']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(DiyField::DiyFieldRule($this), [
            [['columnid', 'slug'], 'required'],
            [['columnid', 'posttime'], 'integer'],
            [['content', 'picurl', 'slug'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(DiyField::DiyFieldRule($this, false), [
            'id' => '单页ID',
            'columnid' => '栏目名称',
            'slug' => '访问链接',
            'picurl' => '缩略图片',
            'content' => '内容',
            'posttime' => '发布时间',
        ]);
    }

    /**
     * @inheritdoc
     * @return InfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InfoQuery(get_called_class());
    }
}
