<?php

namespace app\models\sys;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

/**
 * This is the model class for table "{{%sys_multilang_tpl}}".
 *
 * @property int $id 站点ID
 * @property string $site_name 站点名称：简体中文、English、xxx子网站
 * @property int $template_id 模板id
 * @property string $lang 站点语言包，此语言包必须要有模板的支持
 * @property string $key 站点标识，用于站点访问链接优化标识
 * @property int $back_defautl 是否后台默认
 * @property int $front_default 是否前台默认
 * @property int $orderid 排序
 * @property int $is_visible 是否显示在前台站点切换
 */
class MultilangTpl extends \app\models\base\Sys
{
	public $keyword;
	
	public function behaviors()
	{
	    return [
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
            //后台默认打开
            'defaultBack' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'back_defautl',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'back_defautl',
                ],
                'value' => function ($event) {
                    if(!empty($this->back_defautl)) {
                        MultilangTpl::updateAll(['back_defautl' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
                    }
                    return $this->back_defautl;
                }
            ],
            //前台默认打开
            'defaultFront' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'front_default',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'front_default',
                ],
                'value' => function ($event) {
                    if(!empty($this->front_default)) {
                        MultilangTpl::updateAll(['front_default' => self::STATUS_OFF], ['not' ,['id' => $this->id]]);
                    }
                    return $this->front_default;
                }
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_multilang_tpl}}';
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
            [['lang_name', 'template_id', 'lang', 'key'], 'required'],
            [['template_id', 'back_defautl', 'front_default', 'orderid', 'is_visible'], 'integer'],
            [['lang_name', 'key'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 50],
            
            //默认值
            [['is_visible'], 'default', 'value' => self::STATUS_ON],
            [['front_default', 'back_defautl'], 'default', 'value' => self::STATUS_OFF],
            
            //禁止重复
            [['lang_name', 'lang', 'key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '站点ID',
            'lang_name' => '站点名称',
            'template_id' => '指定模板',
            'lang' => '语言包',
            'key' => '站点标识',
            'back_defautl' => '后台默认',
            'front_default' => '前台默认',
            'orderid' => '排序',
            'is_visible' => '显示在前台',
        ];
    }
    
    /**
     * 一对一联表
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['temp_id' => 'template_id']);
    }
    
    /**
     * 修改模板后，涉及到系统初始化参数时，则删除对应的session
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    /*
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if($insert || !empty(array_intersect(['langs', 'default_lang'], array_keys($changedAttributes)))) {
            Yii::$app->getSession()->remove(InitSysten::INIT_PARAMS);
        }
        
        //配置数据
        //数据结构为：['varname', 'varinfo', 'vargroup', 'vartype', 'varvalue', 'orderid', 'visible']
        $configData = [
            ['config_site_name', '站点名称', '0', 'string', '土人开源营销系统', '97', '1'],
            ['config_site_url', '网站地址', '0', 'string', 'http://www.turen2.com', '96', '1'],
            ['config_author', '网站作者', '0', 'string', 'jorry', '95', '1'],
            ['config_seo_title', 'SEO标题', '0', 'string', '土人开源营销系统', '94', '1'],
            ['config_seo_keyword', '关键字设置', '0', 'string', '土人开源,营销系统,建站,Yii,yiicms', '93', '1'],
            ['config_seo_description', '网站描述', '0', 'bstring', '412412', '92', '1'],
            ['config_copyright', '版权信息', '0', 'string', 'Copyright © 2016 - 2018 turen2.com All Rights Reserved', '91', '1'],
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
    */

    /**
     * @inheritdoc
     * @return MultilangTplQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilangTplQuery(get_called_class());
    }
}
