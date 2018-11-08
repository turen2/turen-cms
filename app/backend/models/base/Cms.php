<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use Yii;
use app\models\cms\Column;
use app\models\cms\Flag;
use app\models\cms\Cate;
use yii\helpers\ArrayHelper;

class Cms extends \app\components\ActiveRecord
{
    /** @var string  */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';
    
    private static $_allColumn = [];
    private static $_allCate = [];
    private static $_allFlag = [];
    
    private static function initData()
    {
        //使用频繁，初始化载入
        if(empty(self::$_allColumn)) {
            self::$_allColumn = Column::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
        
        if(empty(self::$_allCate)) {
            self::$_allCate = Cate::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }
    }
    
    /**
     * 获取所有栏目
     * @return array|string
     */
    public static function ColumnList($columnid = null) {
        self::initData();
        $allColumn = ArrayHelper::map(self::$_allColumn, 'id', 'cname');
        if(is_null($columnid)) {
            return $allColumn;
        } else {
            return isset($allColumn[$columnid])?$allColumn[$columnid]:'';
        }
    }
    
    /**
     * 获取指定类型的栏目数组
     * @param integer $type
     * @return array
     */
    public static function ColumnListByType($type) {
        self::initData();
        $allColumn = self::$_allColumn;//转存
        $tempColumn = [];
        foreach ($allColumn as $key => $column) {
            if($column['type'] == $type) {
                $tempColumn[$column['id']] = $column['cname'];
            }
        }
        
        return $tempColumn;
    }
    
    /**
     * 获取所有类别
     * @return array|string|mixed
     */
    public static function CateList($cateid = null) {
        self::initData();
        $allCate = ArrayHelper::map(self::$_allCate, 'id', 'catename');
        if(is_null($cateid)) {
            return $allCate;
        } else {
            return isset($allCate[$cateid])?$allCate[$cateid]:'';
        }
    }
    
    /**
     * 获取所有标记数组
     * 1.只读取数据库中的对应type的所有flag
     * 2.根据栏目模型中的flag字符串，交集出的flag
     * @return array|string|mixed
     */
    public function getAllFlag($type, $isAll = false, $haveFlag = false) {
        $_key = intval($isAll).intval($haveFlag).$type;//不同参数的调用，返回的结果缓存也不一样
        if(empty(self::$_allFlag[$_key])) {
            $arrFlag = Flag::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach ($arrFlag as $flag) {
                if($type == $flag['type']) {
                    self::$_allFlag[$_key][$flag['flag']] = ($flag['flagname'].($haveFlag?'['.$flag['flag'].']':''));
                }
            }
        }
        
        if($isAll) {
            return isset(self::$_allFlag[$_key])?self::$_allFlag[$_key]:[];
        } else {
            if(!empty($this->flag)) {
                $temp = [];
                $flags = is_array($this->flag)?$this->flag:explode(',', $this->flag);
                foreach ($flags as $flag) {
                    if(isset(self::$_allFlag[$_key][$flag])) {
                        $temp[$flag] = self::$_allFlag[$_key][$flag];
                    }
                }
                
                return $temp;
            } else {
                return [];
            }
        }
    }
}