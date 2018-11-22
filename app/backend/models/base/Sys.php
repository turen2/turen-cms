<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use Yii;
use app\models\cms\Column;

class Sys extends \app\components\ActiveRecord
{
    /**
     * 
     * @return string
     */
    public static function getInitParentStr($className)
    {
        if($this->parentid == Column::COLUMN_TOP_ID) {
            $this->parentstr = '0,';
        } else {
            if($parentModel = Column::find()->current()->andWhere(['id' => $this->parentid])->one()) {
                $this->parentstr = $parentModel->parentstr.$this->parentid.',';
            }
        }
        
        return $this->parentstr;
    }
}