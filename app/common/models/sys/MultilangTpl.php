<?php

namespace common\models\sys;

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
class MultilangTpl extends \common\models\base\Sys
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_multilang_tpl}}';
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