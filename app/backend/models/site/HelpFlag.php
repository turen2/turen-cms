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
 * This is the model class for table "{{%cms_help_flag}}".
 *
 * @property int $id 信息标记id
 * @property string $flag 标记名称
 * @property string $flagname 标记标识
 * @property int $orderid 排列排序
 */
class HelpFlag extends \app\models\base\Site
{
	public $keyword;
	
	private static $_allFlag;

	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
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
        return '{{%site_help_flag}}';
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
            [['flag', 'flagname', 'orderid'], 'required'],
            [['orderid'], 'integer'],
            [['flag', 'flagname'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '信息标记id',
            'flag' => '标记名称',
            'flagname' => '标记标识',
            'orderid' => '排列排序',
        ];
    }
    
    /**
     * 获取原系统的所有标签列表
     * @param string $haveFlag
     * @return string[]
     */
    public static function FlagList($haveFlag = false)
    {
        if(empty(self::$_allFlag)) {
            self::$_allFlag = self::find()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        $flags = [];
        foreach (self::$_allFlag as $flag) {
            $flags[$flag['flag']] = ($flag['flagname'].($haveFlag?'['.$flag['flag'].']':''));
        }
        
        return $flags;
    }

    /**
     * @inheritdoc
     * @return FlagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HelpFlagQuery(get_called_class());
    }
}
