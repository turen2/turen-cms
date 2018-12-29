<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\modules\member;

use Yii;

/**
 * member module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/main-banjia';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\member\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();


        // custom initialization code goes here
    }

}
