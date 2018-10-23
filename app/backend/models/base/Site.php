<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use app\models\site\HelpFlag;
use app\models\site\HelpCate;
use yii\helpers\ArrayHelper;

class Site extends \app\components\ActiveRecord
{
    /** @var string  */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';
    
    private static $_allHelpFlag = [];
    private static $_allHelpCate = [];
    
    /**
     * 获取所有帮助类别
     * @return array|string|mixed
     */
    public function getAllHelpCate($isAll = false) {
        if(empty(self::$_allHelpCate)) {
            self::$_allHelpCate = ArrayHelper::map(HelpCate::find()->orderBy(['orderid' => SORT_DESC])->all(), 'id', 'catename');
        }
        
        if($isAll) {
            return self::$_allHelpCate;
        } else {
            return isset(self::$_allHelpCate[$this->cateid])?self::$_allHelpCate[$this->cateid]:'';
        }
    }
    
    /**
     * 获取所有标记
     * @return array|string|mixed
     */
    public function getAllHelpFlag($isAll = false, $haveHelpFlag = false) {
        $_key = intval($isAll).intval($haveHelpFlag);//不同参数的调用，返回的结果缓存也不一样
        if(empty(self::$_allHelpFlag[$_key])) {
            $arrHelpFlag = HelpFlag::find()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach ($arrHelpFlag as $flag) {
                self::$_allHelpFlag[$_key][$flag['flag']] = ($flag['flagname'].($haveHelpFlag?'['.$flag['flag'].']':''));
            }
        }
        
        if($isAll) {
            return isset(self::$_allHelpFlag[$_key])?self::$_allHelpFlag[$_key]:[];
        } else {
            if(!empty($this->flag)) {
                $temp = [];
                $flags = is_array($this->flag)?$this->flag:explode(',', $this->flag);
                foreach ($flags as $flag) {
                    if(isset(self::$_allHelpFlag[$_key][$flag])) {
                        $temp[$flag] = self::$_allHelpFlag[$_key][$flag];
                    }
                }
                
                return $temp;
            } else {
                return [];
            }
        }
    }
}