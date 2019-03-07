<?php

namespace common\models\ext;

/**
 * This is the ActiveQuery class for [[LinkType]].
 *
 * @see LinkType
 */
class LinkTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LinkType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LinkType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
