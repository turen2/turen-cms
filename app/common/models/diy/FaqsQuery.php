<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\diy;

/**
 * This is the ActiveQuery class for [[Faqs]].
 *
 * @see Faqs
 */
class FaqsQuery extends \common\components\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Faqs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Faqs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
