<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\InsertLangBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%cms_flag}}".
 *
 * @property int $id 信息标记id
 * @property string $flag 标记名称
 * @property string $flagname 标记标识
 * @property integer $type 类型
 * @property int $orderid 排列排序
 * @property string $lang
 */
class Flag extends \app\models\base\Cms
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
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
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
        return '{{%cms_flag}}';
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
            [['flag', 'flagname'], 'required'],
            [['orderid', 'type'], 'integer'],
            [['flag', 'flagname', 'lang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '信息标记id',
            'flagname' => '标记名称',
            'flag' => '标记值',
            'orderid' => '排序',
            'type' => '所属类型',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 获取原系统的所有标签列表
     * @param integer $modelid 模型id
     * @param string $haveFlag 标签名是否带[flag]
     * @return string[]
     */
    public static function FlagList($modelid, $haveFlag = false)
    {
        if(empty(self::$_allFlag)) {
            self::$_allFlag = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        $flags = [];
        foreach (self::$_allFlag as $flag) {
            if($modelid == $flag['type']) {
                $flags[$flag['flag']] = ($flag['flagname'].($haveFlag?'['.$flag['flag'].']':''));
            }
        }
        
        return $flags;
    }

    /**
     * @inheritdoc
     * @return FlagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlagQuery(get_called_class());
    }
}
