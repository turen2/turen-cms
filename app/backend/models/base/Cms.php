<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\base;

use Yii;

class Cms extends \backend\components\ActiveRecord
{
    /** @var string  */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';
}