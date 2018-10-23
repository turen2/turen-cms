<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\validators;

use yii\validators\Validator;

class EscapeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = filter_var($model->$attribute, FILTER_SANITIZE_STRING);
    }
}