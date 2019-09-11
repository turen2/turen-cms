<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;
use app\widgets\laydate\LaydateBehavior;
use app\widgets\fileupload\MultiPicBehavior;
use app\behaviors\AttributeJsonBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use app\bootstrap\InitSysten;

/**
 * This is the model class for table "{{%sys_template}}".
 *
 * @property string $temp_id 模板id
 * @property string $temp_name 模板名称
 * @property string $temp_code 模板编码
 * @property string $picurl 模板缩略图
 * @property string $picarr 模板图片组
 * @property string $developer_name 开发者
 * @property string $design_name 设计师
 * @property string $note 模板说明
 * @property string $langs 支持哪些语言，json格式
 * @property string $posttime 开发的发布时间
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Template extends \app\models\base\Sys
{
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
	        'picarr' => [
	            'class' => MultiPicBehavior::class,
	            'picsAttribute' => 'picarr',
	        ],
	        'langs' => [
	            'class' => AttributeJsonBehavior::class,
	            'jsonAttribute' => 'langs',
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
        return '{{%sys_template}}';
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
            [['temp_name', 'temp_code', 'picurl', 'note'], 'required'],
            [['picarr', 'note', 'temp_code', 'picurl'], 'string'],
            [['created_at', 'updated_at', 'posttime'], 'integer'],
            [['temp_name'], 'string', 'max' => 100],
            [['developer_name', 'design_name'], 'string', 'max' => 30],
            
            //默认值
            [['picarr'], 'default', 'value' => ''],
            [['langs', 'keyword'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'temp_id' => '模板ID',
            'temp_name' => '模板名称',
            'temp_code' => '模板编码',
            'picurl' => '模板缩略图',
            'picarr' => '模板图片组',
            'developer_name' => '开发者',
            'design_name' => '设计师',
            'note' => '模板说明',
            'langs' => '模板支持语言',
            'posttime' => '发布时间',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    /**
     * 获取当前模板支持的语言列表
     * @return mixed[]
     */
    public function tempLangList()
    {
        $langs = Yii::$app->params['config.languages'];
        $tLangs = Json::decode($this->langs);
        
        $tls = [];
        foreach ($tLangs as $value) {
            $tls[$value] = $langs[$value];
        }
        
        return $tls;
    }
    
    public function getLangStr()
    {
        return implode('<br />', $this->tempLangList());
    }
    
    public static function Lang2Str($lang)
    {
        return isset(Yii::$app->params['config.languages'][$lang])?Yii::$app->params['config.languages'][$lang]:'未知';
    }
    
    public static function TemplateCodes()
    {
        $dirs = FileHelper::findDirectories(FileHelper::normalizePath(Yii::getAlias('@frontend/themes/')), ['recursive' => false]);
        $options = [];
        foreach ($dirs as $dir) {
            $dir = FileHelper::normalizePath($dir);
            $name = substr($dir, strpos($dir, 'themes')+7);
            $options[$name] = $name;
        }
        
        return $options;
    }
    
    /**
     * @inheritdoc
     * @return TemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TemplateQuery(get_called_class());
    }
}
