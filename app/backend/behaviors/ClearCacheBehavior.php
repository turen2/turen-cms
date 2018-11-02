<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;

/**
 * 用于指定清理依赖缓存标记的缓存
 * @author jorry
 *
 */
class ClearCacheBehavior extends Behavior
{
    public $cache;
    public $tagName;//要清理的缓存tag
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateAllFrontCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'updateAllFrontCache',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateAllFrontCache',
        ];
    }
    
    public function updateAllFrontCache($event)
    {
        TagDependency::invalidate($this->cache, $this->tagName);
    }
}