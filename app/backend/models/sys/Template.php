<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
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
 * @property int $open_cate 是否支持类别
 * @property string $picurl 模板缩略图
 * @property string $picarr 模板图片组
 * @property string $developer_name 开发者
 * @property string $design_name 设计师
 * @property string $note 模板说明
 * @property string $langs 支持哪些语言，json格式
 * @property string $default_lang 默认语言
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
            [['temp_name', 'temp_code', 'picurl', 'note', 'default_lang'], 'required'],
            [['picarr', 'note', 'temp_code', 'picurl', 'posttime'], 'string'],
            [['created_at', 'updated_at', 'open_cate'], 'integer'],
            [['temp_name'], 'string', 'max' => 100],
            [['developer_name', 'design_name'], 'string', 'max' => 30],
            [['open_cate'], 'default', 'value' => Template::STATUS_ON],
            
            [['langs'], 'safe'],
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
            'open_cate' => '是否支持类别',
            'picurl' => '模板缩略图',
            'picarr' => '模板图片组',
            'developer_name' => '开发者',
            'design_name' => '设计师',
            'note' => '模板说明',
            'langs' => '开通的语言',
            'default_lang' => '后台默认语言',
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
    
    public function getDefaultLangStr()
    {
        return isset(Yii::$app->params['config.languages'][$this->default_lang])?Yii::$app->params['config.languages'][$this->default_lang]:'未知';
    }
    
    public static function Lang2Str($lang)
    {
        return isset(Yii::$app->params['config.languages'][$lang])?Yii::$app->params['config.languages'][$lang]:'未知';
    }
    
    public static function TemplateCodes()
    {
        $dirs = FileHelper::findDirectories(Yii::getAlias('@frontend/themes/'), ['recursive' => false]);
        $options = [];
        foreach ($dirs as $dir) {
            $dir = FileHelper::normalizePath($dir);
            $name = substr($dir, strpos($dir, 'themes')+7);
            $options[$name] = $name;
        }
        
        return $options;
    }
    
    /**
     * 修改模板后，涉及到系统初始化参数时，则删除对应的session
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if($insert || !empty(array_intersect(['langs', 'default_lang', 'open_cate'], array_keys($changedAttributes)))) {
            Yii::$app->getSession()->remove(InitSysten::INIT_PARAMS);
        }
        
        //配置数据
        //数据结构为：['varname', 'varinfo', 'vargroup', 'vartype', 'varvalue', 'orderid', 'visible']
        $configData = [
            ['config_site_name', '站点名称', '0', 'string', '聚万方营销系统', '97', '1'],
            ['config_site_url', '网站地址', '0', 'string', 'http://www.juwanfang.com', '96', '1'],
            ['config_author', '网站作者', '0', 'string', 'jorry', '95', '1'],
            ['config_seo_title', 'SEO标题', '0', 'string', '聚万方营销系统', '94', '1'],
            ['config_seo_keyword', '关键字设置', '0', 'string', '聚万方,营销系统,建站,Yii,yiicms', '93', '1'],
            ['config_seo_description', '网站描述', '0', 'bstring', '412412', '92', '1'],
            ['config_copyright', '版权信息', '0', 'string', 'Copyright © 2016 - 2018 juwanfang.com All Rights Reserved', '91', '1'],
            ['config_hotline', '客服热线', '0', 'string', '400-800-8888', '90', '1'],
            ['config_icp_code', '备案编号', '0', 'string', '442525', '89', '1'],
            ['config_open_site', '启用站点', '0', 'bool', '1', '88', '1'],
            ['config_close_note', '关闭说明', '0', 'bstring', '对不起，网站维护，请稍后登录。\r\n网站维护期间对您造成的不便，请谅解！', '87', '1'],
            ['config_upload_image_type', '上传图片类型', '1', 'string', 'gif|png|jpg|bmp', '86', '1'],
            ['config_upload_file_type', '上传下载文件类型', '1', 'string', 'zip|gz|rar|iso|doc|xls|ppt|wps|txt', '85', '1'],
            ['config_upload_media_type', '上传媒体类型', '1', 'string', 'swf|flv|mpg|mp3|rm|rmvb|wmv|wma|wav', '84', '1'],
            ['config_max_file_size', '上传文件大小', '1', 'number', '2097152', '83', '1'],
            ['config_image_resize', '自动缩略图方式　<br />(是\"裁切\",否\"填充\")', '1', 'bool', '1', '82', '1'],
            ['config_count_code', '流量统计代码', '1', 'bstring', '', '81', '1'],
            ['config_qq_code', '在线QQ　<br />(多个用\",\"分隔)', '1', 'bstring', '', '80', '1'],
            ['config_page_size', '每页显示记录数', '2', 'number', '30', '79', '1'],
            ['config_open_comment', '开启文章评论', '2', 'bool', '1', '21', '1'],
            ['config_alipay_name', '支付宝帐户', '3', 'string', '', '13', '1'],
            ['config_alipay_partner', '支付宝合作身份者ID', '3', 'string', '', '11', '1'],
            ['config_alipay_key', '支付宝安全检验码', '3', 'string', '', '9', '1'],
            ['config_qq_appid', 'QQ登录组件AppID', '3', 'string', '', '7', '1'],
            ['config_qq_appkey', 'QQ登录组件AppKey', '3', 'string', '', '5', '1'],
            ['config_weibo_appid', '微博登录组件AppID', '3', 'string', '', '3', '1'],
            ['config_weibo_appkey', '微博登录组件AppKey', '3', 'string', '', '1', '1'],
            ['config_frontend_logo', '网站前台logo', '4', 'string', '', '99', '0'],
            ['config_backend_logo', '后台登录界面logo', '4', 'string', '', '95', '0'],
        ];
        
        //标签数据
        $flagData = [];
        
        //如果增加了系统中没有的语言，则将会重构与新语言相关的数据
        if($insert || !empty(array_intersect(['langs'], array_keys($changedAttributes)))) {
            //重构数据
            //特殊原因，导致json相关数据被清空，这里重新查询
            $tempModel = self::findOne($this->temp_id);
            $langs = Json::decode($tempModel->langs);
            foreach ($langs as $lang) {
                if(!Config::find()->where(['lang' => $lang])->exists()) {
                    Yii::$app->getDb()->createCommand()->batchInsert(Config::tableName(), ['varname', 'varinfo', 'vargroup', 'vartype', 'varvalue', 'orderid', 'visible'], $configData)->execute();
                    Config::updateAll(['lang' => $lang], ['lang' => '']);
                }
            }
        }
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
