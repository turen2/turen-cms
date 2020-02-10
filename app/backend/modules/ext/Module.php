<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\modules\ext;

/**
 * ext module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\ext\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
