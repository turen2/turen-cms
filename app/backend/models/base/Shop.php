<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use app\models\cms\Flag;
use app\models\shop\ProductCate;
use app\models\cms\Column;
use app\models\shop\Brand;
use yii\helpers\ArrayHelper;

class Shop extends \app\components\ActiveRecord
{
    private static $_allColumn = [];
    private static $_allFlag = [];
    private static $_allProductCate = [];
    private static $_allProductBrand = [];
    
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
    public function getAllFlag($type, $isAll = false, $haveFlag = false) {
        $_key = intval($isAll).intval($haveFlag);//不同参数的调用，返回的结果缓存也不一样
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
    
    /**
     * 获取所有产品类别
     * @return array|string|mixed
     */
    public function getAllProductCate($isAll = false) {
        if(empty(self::$_allProductCate)) {
            self::$_allProductCate = ArrayHelper::map(ProductCate::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), 'id', 'cname');
        }
        
        if($isAll) {
            return self::$_allProductCate;
        } else {
            return isset(self::$_allProductCate[$this->pcateid])?self::$_allProductCate[$this->pcateid]:'';
        }
    }
    
    /**
     * 获取所有产品品牌
     * @return array|string|mixed
     */
    public function getAllProductBrand($isAll = false) {
        if(empty(self::$_allProductBrand)) {
            self::$_allProductBrand = ArrayHelper::map(Brand::find()->current()->orderBy(['orderid' => SORT_DESC])->all(), 'id', 'bname');
        }
        
        if($isAll) {
            return self::$_allProductBrand;
        } else {
            return isset(self::$_allProductBrand[$this->brand_id])?self::$_allProductBrand[$this->brand_id]:'';
        }
    }
}