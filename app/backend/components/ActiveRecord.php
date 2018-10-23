<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\components;

use Yii;

class ActiveRecord extends \yii\db\ActiveRecord
{
    //字段null值
    const DEFAULT_NULL = '-1';
    
    //顶级id为0
    const TOP_ID = 0;
    
    //审核状态
    const STATUS_ON = 1;
    const STATUS_OFF = 0;
    
    //是否状态
    const IS_ON = 1;
    const IS_OFF = 0;
    
    //删除状态
    const IS_DEL = 1;
    const IS_NOT_DEL = 0;
    
    //移动方向
    const ORDER_UP_TYPE = 'up';
    const ORDER_DOWN_TYPE = 'down';
    
    private $_admin;
    
    public function init()
    {
        parent::init();
        
        if(!Yii::$app->getUser()->getIsGuest()) {
            $this->_admin = Yii::$app->getUser()->getIdentity();
        }
    }
    
    public function getAdmin()
    {
        return $this->_admin;
    }
    
    /*
     * 获取$parentStr的第二位id
     *
     * @access public
     * @param  $str    string  要拆分的整型序列如1,2,3
     * @param  $$i     int     为空返回str数组的第二位(第一位为0)
     * @return $topid  int     str的第一位
     */
    public function getTopID($parentStr = 'parentstr', $i = 1)
    {
        if(isset($this->{$parentStr})) {
            if($this->{$parentStr} == '0,') {
                $topid = 0;
            } else {
                $ids = explode(',', $this->{$parentStr});
                $topid = isset($ids[$i]) ? $ids[$i] : '';
            }
            
            return $topid;
        }
        
        return null;
    }
    
    /**
     * 构建parent str
     * @return string
     */
    public function initParentStr($primayKey = 'id', $parentKey = 'parentid', $parentStr = 'parentstr')
    {
        $parentModel = self::find()->andWhere([$primayKey => $this->{$parentKey}])->one();
        if($parentModel) {
            if($parentModel->{$primayKey} == self::TOP_ID) {
                $parentstr = '0,';
            } else {
                $parentstr = ($parentModel->{$parentStr}).($parentModel->{$primayKey}).',';
            }
        } else {
            $parentstr = '0,';
        }
        
        return $parentstr;
    }
    
    /*
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        //注意：从表单提交上来的所有数据都是字符串，当数字字段被提交上来后，在数据库中将会转化为null,
        //因此会报字段不能为null的错。
        
        //排序填充问题
//         if(isset($this->orderid) && $this->orderid === '') {
//             //使用最大排序
//             $className = get_class($this);
//             $maxModel = $className::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
//             if($maxModel) {
//                 $this->orderid = $maxModel->orderid + 1;
//             } else {
//                 $this->orderid = Yii::$app->params['config.orderid'];//配置默认值
//             }
//         }
        
        //发布时间填充问题
//         if(isset($this->posttime) && $this->posttime === '') {
//             $this->posttime = time();
//         }
        
        //显示状态问题
//         if(isset($this->status) && $this->status === '') {
//             $this->status = self::STATUS_ON;
//         }
        
        //默认点击次数问题
//         if(isset($this->hits) && $this->hits === '') {
//             $this->hits = Yii::$app->params['config.hits'];
//         }
        
        return true;
    }
    */
}