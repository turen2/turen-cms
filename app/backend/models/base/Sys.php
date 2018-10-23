<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use Yii;
use app\models\cms\Column;
use app\models\cms\Flag;
use yii\helpers\ArrayHelper;

class Sys extends \app\components\ActiveRecord
{
    private static $_allColumn = [];
    private static $_allFlag = [];
    
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
    
    /**
     * 获取所有栏目
     * @return array|string|mixed
     */
    public function getAllColumn($isAll = false) {
        if(empty(self::$_allColumn)) {
            self::$_allColumn = ArrayHelper::map(Column::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), 'id', 'cname');
        }
        
        if($isAll) {
            return self::$_allColumn;
        } else {
            return isset(self::$_allColumn[$this->columnid])?self::$_allColumn[$this->columnid]:'';
        }
    }
    
    /**
     * 获取所有标记
     * @return array|string|mixed
     */
    public function getAllFlag($isAll = false) {
        if(empty(self::$_allFlag)) {
            self::$_allFlag = ArrayHelper::map(Flag::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), 'id', 'flagname');
        }
        
        if($isAll) {
            //return self::$_allFlag;
            return isset(self::$_allFlag[$_key])?self::$_allFlag[$_key]:[];
        } else {
            if(!empty($this->flag)) {
                $temp = [];
                $flags = is_array($this->flag)?$this->flag:explode(',', $this->flag);
                foreach ($flags as $flag) {
                    if(isset(self::$_allFlag[$flag])) {
                        $temp[$flag] = self::$_allFlag[$flag];
                    }
                }
                
                return $temp;
            } else {
                return [];
            }
        }
    }
}