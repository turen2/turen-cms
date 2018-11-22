<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\base;

use app\models\shop\Brand;
use yii\helpers\ArrayHelper;

class Shop extends \app\components\ActiveRecord
{
    private static $_allProductBrand = [];
    
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