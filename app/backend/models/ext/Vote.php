<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\behaviors\InsertLangBehavior;
use app\widgets\laydate\LaydateBehavior;

/**
 * This is the model class for table "{{%ext_vote}}".
 *
 * @property string $id 投票id
 * @property string $title 投票标题
 * @property string $content 投票描述
 * @property string $starttime 开始时间
 * @property string $endtime 结束时间
 * @property int $isguest 游客投票
 * @property int $isview 查看投票
 * @property string $intval 投票间隔
 * @property int $isradio 是否多选
 * @property string $orderid 排列排序
 * @property string $posttime 发布时间
 * @property int $status 显示状态
 * @property string $lang
 */
class Vote extends \app\models\base\Ext
{
    const RADIO_SINGLE = 1;//单选
    const RADIO_MULTI = 2;//多选
    
    const GUEST_YES = 1;//允许游客
    const GUEST_NO = 0;//不允许游客
    
    const VIEW_YES = 1;//投票完成后是否查看，是
    const VIEW_NO = 0;//投票完成后是否查看，否
    
	public $keyword;
	public $options;
	
	public function behaviors()
	{
	    return [
	        'starttime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'starttime',
	        ],
	        'endtime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'endtime',
	        ],
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
	        'defaultStarttime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'starttime',
	            'updatedAtAttribute' => false,
	        ],
	        'defaultEndtime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'endtime',
	            'updatedAtAttribute' => false,
	        ],
	        'defaultOrderid' => [
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'orderid',
	                //ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
	            ],
	            'value' => function ($event) {
    	            if(empty($this->orderid)) {
    	                $maxModel = self::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
    	                if($maxModel) {
    	                    return $maxModel->orderid + 1;
    	                } else {
    	                    return Yii::$app->params['config.orderid'];//配置默认值
    	                }
    	            }
    	            
    	            return $this->orderid;
	            }
            ],
        ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ext_vote}}';
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
            [['intval', 'orderid', 'isguest', 'isview', 'isradio', 'status'], 'integer'],
            [['content', 'starttime', 'endtime', 'posttime'], 'string'],
            [['title'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 8],
            //静态默认值由规则来赋值
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['isradio'], 'default', 'value' => self::RADIO_SINGLE],
            [['isguest'], 'default', 'value' => self::GUEST_YES],
            [['isview'], 'default', 'value' => self::VIEW_YES],
            [['intval'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '投票id',
            'title' => '投票标题',
            'content' => '投票描述',
            'starttime' => '开始时间',
            'endtime' => '结束时间',
            'isguest' => '游客投票',
            'isview' => '查看投票',
            'intval' => '投票间隔',
            'isradio' => '是否多选',
            'orderid' => '排列排序',
            'posttime' => '发布时间',
            'status' => '显示状态',
            'lang' => '多语言',
        ];
    }
    
    /**
     * 修改数据项
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $oldOptions = isset($this->options['old'])?$this->options['old']:[];
        $newOptions = isset($this->options['new'])?$this->options['new']:[];
        
        //清理&更新
        if(!$insert) {
            //取出要删除的id值
            $ids = ArrayHelper::map(VoteOption::find()->select(['id'])->where(['and', ['voteid' => $this->id], ['not in', 'id', array_keys($oldOptions)]])->all(), 'id', 'id');
            VoteOption::deleteAll(['id' => $ids]);
            
            //更新未删除的
            foreach ($oldOptions as $id => $oldOption) {
                VoteOption::updateAll(['options' => $oldOption], ['id' => $id]);
            }
        }
        
        //插入新的
        foreach ($newOptions as $id => $oldOption) {
            $model = new VoteOption();
            $model->voteid = $this->id;
            $model->options = $oldOption;
            $model->save(false);
        }
    }
    
    /**
     * 主表删除，子表跟着删除
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterDelete()
     */
    public function afterDelete()
    {
        parent::afterDelete();
        
        VoteOption::deleteAll(['voteid' => $this->id]);
    }

    /**
     * @inheritdoc
     * @return VoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoteQuery(get_called_class());
    }
}
