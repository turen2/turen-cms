<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\ext;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%ext_vote_data}}".
 *
 * @property string $id 投票数据id
 * @property string $voteid 投票id
 * @property string $optionid 选票id
 * @property string $userid 投票人id
 * @property string $posttime 投票时间
 * @property string $ip 投票ip
 */
class VoteData extends \app\models\base\Ext
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
	        //动态值由此属性行为处理
	        'defaultPosttime' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'posttime',//投票时间
	            'updatedAtAttribute' => false,
	        ],
        ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ext_vote_data}}';
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
            [['voteid', 'optionid', 'userid', 'posttime', 'ip'], 'required'],
            [['voteid', 'userid', 'posttime'], 'integer'],
            [['optionid'], 'string'],
            [['ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '投票数据id',
            'voteid' => '投票id',
            'optionid' => '选票id',
            'userid' => '投票人id',
            'posttime' => '投票时间',
            'ip' => '投票ip',
        ];
    }

    /**
     * @inheritdoc
     * @return VoteDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoteDataQuery(get_called_class());
    }
}
