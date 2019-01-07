<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

/**
 * This is the ActiveQuery class for [[Photo]].
 *
 * @see Photo
 */
class PhotoQuery extends \app\components\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Photo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Photo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
