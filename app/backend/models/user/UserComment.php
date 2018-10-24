<?php

namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use app\behaviors\InsertLangBehavior;
use app\widgets\laydate\LaydateBehavior;
use app\models\cms\Column;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "ss_user_comment".
 *
 * @property string $uc_id 评论id
 * @property int $uc_pid 回复的主评论id，自己是主评论时，值为-1
 * @property string $uc_typeid 信息类型
 * @property string $uc_model_id 信息id
 * @property int $uid 用户id
 * @property string $username 用户名
 * @property string $uc_note 评论内容
 * @property string $uc_reply 回复内容
 * @property string $uc_link 评论网址
 * @property string $uc_ip 评论ip
 * @property int $status 是否前台显示
 * @property string $lang 多语言
 * @property string $reply_time 回复时间
 * @property string $created_at 发表评论的时间
 */
class UserComment extends \app\models\base\User
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        'createdat' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'created_at',
	        ],
	        'replytime' => [
	            'class' => LaydateBehavior::class,
	            'timeAttribute' => 'reply_time',
	        ],
	        'insertlang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_comment}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //静态默认值由规则来赋值
        //[['status'], 'default', 'value' => self::STATUS_ON],
        //[['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        return [
            [['uc_typeid', 'uc_model_id' ,'uc_note'], 'required'],
            [['uc_pid', 'uid', 'status'], 'integer'],
            [['username', 'uc_ip'], 'string', 'max' => 30],
            [['uc_note', 'uc_reply'], 'string', 'max' => 255],
            [['uc_link'], 'string', 'max' => 130],
            [['lang'], 'string', 'max' => 8],
            [['created_at', 'reply_time'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uc_id' => 'ID',
            'uc_pid' => '父评论',
            'uc_typeid' => '对象类型',
            'uc_model_id' => '评论对象',
            'uid' => '用户',
            'username' => '用户名',
            'uc_note' => '评论内容',
            'uc_reply' => '回复内容',
            'uc_link' => '评论网址',
            'uc_ip' => '评论IP',
            'status' => '是否显示',
            'lang' => '多语言',
            'reply_time' => '回复时间',
            'created_at' => '发表时间',
        ];
    }
    
    public function getObjectLink()
    {
        if(in_array($this->uc_typeid, Column::ColumnConvert('id2id'))) {
            $className = Column::ColumnConvert('id2class', $this->uc_typeid);
            $typeName = Column::ColumnConvert('id2name', $this->uc_typeid);
            
            $id = $this->uc_model_id;
            $primaryKey = $className::primaryKey()[0];
            
            $model = $className::find()->current()->andWhere([$primaryKey => $id])->one();
            
            return empty($model)?'':$model->title.' ['.$typeName.']';
        } else {
            return '';
        }
    }
    
    /**
     * 一对一联表
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'uid']);
    }

    /**
     * @inheritdoc
     * @return UserCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserCommentQuery(get_called_class());
    }
}
