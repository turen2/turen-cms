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
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%cms_flag}}".
 *
 * @property int $id 信息标记id
 * @property string $flag 标记名称
 * @property string $flagname 标记标识
 * @property integer $type 类型
 * @property integer $columnid 所属栏目
 * @property int $orderid 排列排序
 * @property string $lang
 */
class Flag extends \backend\models\base\Cms
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
            [['flag', 'flagname', 'columnid'], 'required'],
            [['orderid', 'type', 'columnid'], 'integer'],
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
            'columnid' => '所属栏目',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 获取原系统的指定模型的标签列表
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
     * 获取原系统的指定栏目标签列表
     * @param integer $columnid 栏目id
     * @param string $haveFlag 标签名是否带[flag]
     * @return string[]
     */
    public static function ColumnFlagList($columnid, $haveFlag = false)
    {
        if(empty(self::$_allFlag)) {
            self::$_allFlag = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }

        $flags = [];
        foreach (self::$_allFlag as $flag) {
            if(!is_null($columnid) && $columnid == $flag['columnid']) {
                $flags[$flag['flag']] = ($flag['flagname'].($haveFlag?'['.$flag['flag'].']':''));
            }
        }

        return $flags;
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $columnModel = Column::findOne($this->columnid);
        if($columnModel) {
            $this->type = $columnModel->type;
        }

        return true;
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
