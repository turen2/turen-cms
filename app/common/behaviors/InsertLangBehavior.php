<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\behaviors;

use Yii;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * ```php
 * use app\behaviors;
 *
 * public function behaviors()
 * {
 *     return [
 *         InsertLangBehavior::class,
 *     ];
 * }
 * ```
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => InsertLangBehavior::class,
 *             'insertLangAttribute' => 'lang',
 *         ],
 *     ];
 * }
 * ```
 */
class InsertLangBehavior extends AttributeBehavior
{
    
    public $insertLangAttribute = 'lang';
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->insertLangAttribute],
            ];
        }
    }
    
    /**
     * 重写取值方式
     * {@inheritDoc}
     * @see \yii\behaviors\AttributeBehavior::evaluateAttributes()
     */
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array) $this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                if (is_string($attribute)) {
                    if ($this->preserveNonEmptyValues && !empty($this->owner->$attribute)) {
                        continue;
                    }
                    
                    if($attribute == $this->insertLangAttribute) {
                        $this->owner->$attribute = GLOBAL_LANG;
                    }
                }
            }
        }
    }
}
