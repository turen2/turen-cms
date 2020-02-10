<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use backend\behaviors\InsertLangBehavior;
use backend\models\cms\Column;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "ss_user_favorite".
 *
 * @property string $uf_id 收藏id
 * @property string $uf_typeid 信息类型：article、file、photo、video、product
 * @property string $uf_model_id 信息id
 * @property string $uf_data 附加数据，如：产品降价至多少提醒
 * @property int $uid 用户id
 * @property string $uf_link 当前收藏时的网址
 * @property int $uf_star 收藏的星期：1~5星
 * @property string $uf_ip ip地址
 * @property string $lang 多语言
 * @property string $created_at 评论时间
 */
class Favorite extends \backend\models\base\User
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
            [['uf_typeid', 'uf_model_id', 'uid'], 'required'],
            [['uf_model_id', 'uid', 'uf_star', 'created_at'], 'integer'],
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
            'uf_id' => '收藏id',
            'uf_typeid' => '对象类型',
            'uf_model_id' => '收藏对象',
            'uf_data' => '附加数据',
            'uid' => '用户',
            'uf_link' => '当前网址',
            'uf_star' => '星级',
            'uf_ip' => 'IP',
            'lang' => '多语言',
            'created_at' => '收藏时间',
        ];
    }
    
    /**
     * 关联收藏对象名
     * @return string
     */
    public function getObjectName()
    {
        if(in_array($this->uf_typeid, Column::ColumnConvert('id2id'))) {
            $className = Column::ColumnConvert('id2class', $this->uf_typeid);
            $typeName = Column::ColumnConvert('id2name', $this->uf_typeid);
            
            $id = $this->uf_model_id;
            $primaryKey = $className::primaryKey()[0];
            
            $model = $className::find()->current()->andWhere([$primaryKey => $id])->one();
            
            return empty($model)?'':$model->title.' ['.$typeName.']';
        } else {
            return '';
        }
    }

    /**
     * 附加数据
     */
    public function getMoreData()
    {
        if(!empty($this->uf_data)) {
            if($this->uf_typeid == Column::COLUMN_TYPE_PRODUCT) {
                return '待价:'.$this->uf_data;
            }
        }
        
        return '未定义';
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
     * @return FavoriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FavoriteQuery(get_called_class());
    }
}
