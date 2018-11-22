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
use yii\db\ActiveRecord;
use app\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%cms_src}}".
 *
 * @property string $id 来源id
 * @property string $srcname 来源名称
 * @property string $linkurl 来源地址
 * @property string $orderid 来源排序
 * @property string $lang
 */
class Src extends \app\models\base\Cms
{
	public $keyword;
	
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
        return '{{%cms_src}}';
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
            [['srcname', 'linkurl'], 'required'],
            [['orderid'], 'integer'],
            [['srcname'], 'string', 'max' => 50],
            [['linkurl'], 'string', 'max' => 150],
            [['lang'], 'string', 'max' => 8],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '来源id',
            'srcname' => '来源名称',
            'linkurl' => '来源地址',
            'orderid' => '来源排序',
            'lang' => '语言',
        ];
    }

    /**
     * @inheritdoc
     * @return SrcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SrcQuery(get_called_class());
    }
}
