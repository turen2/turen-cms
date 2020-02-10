<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\components;

class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * 活动状态
     * @param string $field
     * @param int $value
     * @return \backend\components\ActiveQuery
     */
    public function active($field = 'status', $value = ActiveRecord::STATUS_ON)
    {
        return $this->andWhere('[['.$field.']]='.$value);
    }
    
    /**
     * 指定审核状态
     * @param string $field
     * @param int $value
     * @return \backend\components\ActiveQuery
     */
    public function status($field = 'status', $value = ActiveRecord::STATUS_ON)
    {
        return $this->andWhere('[['.$field.']]='.$value);
    }
    
    /**
     * 指定删除状态
     * 默认为已经删除的状态
     * @return \backend\components\ActiveQuery
     */
    public function delstate($status = ActiveRecord::IS_DEL)
    {
        return $this->andWhere('[[delstate]]='.$status);
    }
    
    /**
     * 当前语言
     * @return \backend\components\ActiveQuery
     */
    public function current()
    {
        return $this->andWhere('[[lang]]='.'\''.GLOBAL_LANG.'\'');
    }
    
    /**
     * @inheritdoc
     * @return Column[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * @inheritdoc
     * @return Column|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}