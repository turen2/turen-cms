<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\diyfield;

use Yii;
use yii\db\ActiveRecord;

class DiyFieldBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidateField',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveField',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveField',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDeleteField',
        ];
    }
    
    public function beforeValidateField()
    {
        
    }

    public function afterSaveField()
    {
        
    }

    public function afterDeleteField()
    {
        
    }
}