<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\components;

class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * 活动状态
     * @return \app\components\ActiveQuery
     */
    public function active()
    {
        return $this->andWhere('[[status]]='.ActiveRecord::STATUS_ON);
    }
    
    /**
     * 指定审核状态
     * @param integer $status
     * @return \app\components\ActiveQuery
     */
    public function status($status = ActiveRecord::STATUS_ON)
    {
        return $this->andWhere('[[status]]='.$status);
    }
    
    /**
     * 指定删除状态
     * 默认为已经删除的状态
     * @return \app\components\ActiveQuery
     */
    public function delstate($status = ActiveRecord::IS_DEL)
    {
        return $this->andWhere('[[delstate]]='.$status);
    }
    
    /**
     * 当前语言
     * @return \app\components\ActiveQuery
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