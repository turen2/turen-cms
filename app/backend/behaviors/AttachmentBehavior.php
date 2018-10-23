<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use yii\base\Behavior;
use app\models\tools\Attachment;

//默认绑定资料管理器Attachment

/**
 * ```php
 * use app\behaviors\AttachmentBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         AttachmentBehavior::class,
 *     ];
 * }
 * ```
 */
class AttachmentBehavior extends Behavior
{
    public function init()
    {
        parent::init();
        
        //
    }
    
    //获取附件方法
    public function getAttachment($attribute, $multiple = false)
    {
        $owner= $this->owner;
        $value = $owner->{$attribute};
        
        if($multiple) {
            if(!empty($value)) {
                $names = explode(',', $value);
                foreach ($names as $key => $name) {
                    $names[$key] = substr(basename($name), 0, 32);//校验md5
                }
                $models = Attachment::find()->where(['in', 'md5', $names])->all();
            } else {
                $models = [];
            }
            
            return $models;
        } else {
            if($value) {
                $model = Attachment::findOne(['md5' => substr(basename($value), 0, 32)]);//校验md5
            } else {
                $model = [];
            }
            
            return $model;
        }
    }
}
