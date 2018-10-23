<?php

namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "ss_user_favorite".
 *
 * @property string $ufid 收藏id
 * @property string $uf_class_name 信息类型：article、file、photo、video、product
 * @property string $uf_model_id 信息id
 * @property string $uf_data 附加数据，如：产品降价至多少提醒
 * @property int $uid 用户id
 * @property string $uf_link 当前收藏时的网址
 * @property int $uf_star 收藏的星期：1~5星
 * @property string $uf_ip ip地址
 * @property string $lang 多语言
 * @property string $created_at 评论时间
 */
class UserFavorite extends \app\models\base\User
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
	        'insertlang' => [//自动填充多站点和多语言
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
        return '{{%user_favorite}}';
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
            [['uf_class_name', 'uf_model_id', 'uf_data', 'uf_link', 'uf_ip', 'lang', 'created_at'], 'required'],
            [['uf_model_id', 'uid', 'uf_star', 'created_at'], 'integer'],
            [['uf_class_name'], 'string', 'max' => 60],
            [['uf_data'], 'string', 'max' => 255],
            [['uf_link'], 'string', 'max' => 200],
            [['uf_ip'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ufid' => '收藏id',
            'uf_class_name' => '信息类型：article、file、photo、video、product',
            'uf_model_id' => '信息id',
            'uf_data' => '附加数据，如：产品降价至多少提醒',
            'uid' => '用户id',
            'uf_link' => '当前收藏时的网址',
            'uf_star' => '收藏的星期：1~5星',
            'uf_ip' => 'ip地址',
            'lang' => '多语言',
            'created_at' => '评论时间',
        ];
    }

    /**
     * @inheritdoc
     * @return UserFavoriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserFavoriteQuery(get_called_class());
    }
}
