<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\validators;

use yii\validators\Validator;

class EscapeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = filter_var($model->$attribute, FILTER_SANITIZE_STRING);
    }
}