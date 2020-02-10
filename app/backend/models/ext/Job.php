<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use backend\behaviors\InsertLangBehavior;
use backend\widgets\laydate\LaydateBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%ext_job}}".
 *
 * @property string $id 招聘信息id
 * @property string $title 位岗名称
 * @property string $jobplace 工作地点
 * @property string $jobdescription 工作性质
 * @property int $employ 招聘人数
 * @property int $jobsex 性别要求，1为男
 * @property string $treatment 工资待遇
 * @property string $usefullife 有效期
 * @property string $experience 工作经验
 * @property string $education 学历要求
 * @property string $joblang 言语能力
 * @property string $workdesc 职位描述
 * @property string $content 职位要求
 * @property string $orderid 排列排序
 * @property string $posttime 发布时间
 * @property int $status 显示状态
 * @property string $lang
 */
class Job extends \backend\models\base\Ext
{
    const SEX_MALE = 1;//男性
    const SEX_FEMALE = 2;//女性
    
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
        return '{{%ext_job}}';
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
            [['title'], 'required'],
            [['employ', 'orderid', 'posttime'], 'integer'],
            [['workdesc', 'content'], 'string'],
            [['title', 'jobdescription', 'treatment', 'usefullife', 'experience', 'joblang'], 'string', 'max' => 50],
            [['jobplace', 'education'], 'string', 'max' => 80],
            [['jobsex', 'status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['jobsex'], 'default', 'value' => self::SEX_MALE],
            [['employ'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '招聘信息id',
            'title' => '位岗名称',
            'jobplace' => '工作地点',
            'jobdescription' => '工作性质',
            'employ' => '招聘人数',
            'jobsex' => '性别要求',
            'treatment' => '工资待遇',
            'usefullife' => '有效期',
            'experience' => '工作经验',
            'education' => '学历要求',
            'joblang' => '言语能力',
            'workdesc' => '职位描述',
            'content' => '职位要求',
            'orderid' => '排列排序',
            'posttime' => '发布时间',
            'status' => '显示状态',
            'lang' => '多语言',
        ];
    }

    /**
     * @inheritdoc
     * @return JobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobQuery(get_called_class());
    }
}
