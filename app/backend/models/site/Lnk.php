<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\site;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%site_flag}}".
 *
 * @property int $id 信息标记id
 * @property string $flag 标记名称
 * @property string $lnk_name 标记标识
 * @property int $orderid 排列排序
 * @property string $lang
 */
class Lnk extends \app\models\base\Site
{
	public $keyword;

	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => false,
	        ],
	        //动态值由此属性行为处理
	        'defaultOrderid' => [
	            'class' => OrderDefaultBehavior::class,
            ],
	    ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_lnk}}';
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
            [['lnk_name', 'lnk_link', 'lnk_ico'], 'required'],
            [['lnk_id', 'orderid', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lnk_id' => '快捷ID',
            'lnk_name' => '快捷名称',
            'lnk_link' => '链接',
            'lnk_ico' => 'ICO图标',
            'orderid' => '排序',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     * @return LnkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LnkQuery(get_called_class());
    }
}
