<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace common\exception;

use yii\base\Exception;

class ModelAttributeException extends Exception
{
    public function getName()
    {
        return '请在当前模型上添加属性：public $level;';
    }
}
