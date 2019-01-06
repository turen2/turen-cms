<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\sys;

use Yii;
use yii\helpers\FileHelper;

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
class Template extends \common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_template}}';
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
     * @inheritdoc
     * @return TemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TemplateQuery(get_called_class());
    }
}
