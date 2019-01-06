<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\sys;

use yii\db\Query;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "{{%sys_multilang_tpl}}".
 *
 * @property int $id 站点ID
 * @property string $site_name 站点名称：简体中文、English、xxx子网站
 * @property int $template_id 模板id
 * @property string $lang_sign 站点语言包，此语言包必须要有模板的支持
 * @property string $key 站点标识，用于站点访问链接优化标识
 * @property int $back_default 是否后台默认
 * @property int $front_default 是否前台默认
 * @property int $orderid 排序
 * @property int $is_visible 是否显示在前台站点切换
 */
class MultilangTpl extends \common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_multilang_tpl}}';
    }
    
    /**
     * 系统初始化，必须按照以下格式：
     * Yii::$app->params['config_init_langs']
     * Yii::$app->params['config_init_default_lang']
     * Yii::$app->params['config_init_default_lang_key']
     * Yii::$app->params['config_init_template_id']
     * 
     * @throws InvalidConfigException
     * @return string[]|unknown[]|unknown[][][]
     */
    public static function LangList()
    {
        $multilangTpls = (new Query())->from(self::tableName())->all();//query为了效率
        $allLang = [];
        $defaultLang = '';
        $defaultLangKey = '';
        $templateId = '';
        
        foreach ($multilangTpls as $multilangTpl) {
            if($multilangTpl['front_default']) {
                $defaultLang = $multilangTpl['lang_sign'];//只用来指定系统语言包
                $defaultLangKey = $multilangTpl['key'];//url key
                $templateId = $multilangTpl['template_id'];//模板id
            }
            $allLang[$multilangTpl['key']] = [
                'sign' => $multilangTpl['lang_sign'],
                'name' => $multilangTpl['lang_name'],
                'tid' => $multilangTpl['template_id'],
            ];
        }
        
        if(empty($allLang)) {
            throw new InvalidConfigException('系统管理/多语言管理：未设置语言。');
        }
        
        if($defaultLang === '') {
            throw new InvalidConfigException('系统管理/多语言管理：未设置默认语言包。');
        }
        
        if($defaultLangKey === '') {
            throw new InvalidConfigException('系统管理/多语言管理：未设置默认语言key。');
        }
        
        if($templateId === '') {
            throw new InvalidConfigException('系统管理/多语言管理：未设置站点模板。');
        }
        
        //所有语言+前台默认语言
        return [
            'config_init_langs' => $allLang,
            'config_init_default_lang' => $defaultLang,
            'config_init_default_lang_key' => $defaultLangKey,
            'config_init_template_id' => $templateId,
        ];
    }
    
    /**
     * @inheritdoc
     * @return MultilangTplQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilangTplQuery(get_called_class());
    }
}