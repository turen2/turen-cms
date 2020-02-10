<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\select2;

use Yii;
use yii\db\ActiveRecord;
use backend\models\cms\TagAssign;
use backend\models\cms\Tag;

class TaggableBehavior extends \yii\base\Behavior
{
    private $_tags;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveTaggable',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveTaggable',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteTaggable',
        ];
    }

    public function getTagAssigns()
    {

        return $this->owner->hasMany(TagAssign::class, ['item_id' => $this->owner->primaryKey()[0]])->where(['class' => $this->ownerShortClassName()]);
    }

    public function getTags()
    {
        return $this->owner->hasMany(Tag::class, ['tag_id' => 'tag_id'])->via('tagAssigns');
    }

    public function getTagNames()
    {
        return implode(',', $this->getTagsArray());
    }

    public function setTagNames($values)
    {
        $this->_tags = $this->filterTagValues($values);
    }

    public function getTagsArray()
    {
        if($this->_tags === null){
            $this->_tags = [];
            foreach($this->owner->tags as $tag) {
                $this->_tags[] = $tag->name;
            }
        }
        return $this->_tags;
    }

    public function afterSaveTaggable()
    {
        if(!$this->owner->isNewRecord) {
            $this->beforeDeleteTaggable();
        }

        if($this->_tags === null) {
            $this->_tags = [];
        }

        if(count($this->_tags)) {
            $tagAssigns = [];
            //$modelClass = get_class($this->owner);
            foreach ($this->_tags as $name) {
                if (!($tag = Tag::findOne(['name' => $name]))) {
                    $tag = new Tag(['name' => $name]);
                }
                $tag->frequency++;
                if ($tag->save()) {
                    $updatedTags[] = $tag;
                    $tagAssigns[] = [$this->ownerShortClassName(), $this->owner->primaryKey, $tag->tag_id];
                }
            }

            if(count($tagAssigns)) {
                Yii::$app->db->createCommand()->batchInsert(TagAssign::tableName(), ['class', 'item_id', 'tag_id'], $tagAssigns)->execute();
                $this->owner->populateRelation('tags', $updatedTags);
            }
        }
    }

    public function beforeDeleteTaggable()
    {
        $pks = [];

        foreach($this->owner->tags as $tag){
            $pks[] = $tag->primaryKey;
        }

        if (count($pks)) {
            Tag::updateAllCounters(['frequency' => -1], ['in', 'tag_id', $pks]);
        }
        
        Tag::deleteAll(['frequency' => 0]);
        TagAssign::deleteAll(['class' => $this->ownerShortClassName(), 'item_id' => $this->owner->primaryKey]);
    }

    /**
     * Filters tags.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterTagValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }

    private function ownerShortClassName()
    {
        $reflect = new \ReflectionClass($this->owner);//反射获取短类名
        return $reflect->getShortName();
    }
}