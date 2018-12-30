<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExtNav]].
 *
 * @see ExtNav
 */
class ExtNavQuery extends \app\components\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExtNav[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExtNav|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
