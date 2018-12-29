<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CmsBlock]].
 *
 * @see CmsBlock
 */
class CmsBlockQuery extends \app\components\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return CmsBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CmsBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
