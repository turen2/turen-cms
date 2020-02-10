<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace mobile\behaviors;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\Controller;

class PlusViewBehavior extends \yii\base\Behavior
{
    public $modelClass;

    public $slug = '';

    public $field = 'hits';

    public function init()
    {
        parent::init();

        //各种校验参数
        if(empty($this->modelClass)) {
            throw new InvalidArgumentException('Parameter Error.');
        }
    }

    public function attach($owner)
    {
        $this->owner = $owner;
        $owner->on(Controller::EVENT_AFTER_ACTION, [$this, 'afterPlus']);
    }

    public function afterPlus()
    {
        $request = Yii::$app->request;
        $agent = $request->getUserAgent();
        $ip = $request->getUserIP();

        $key = 'plus_duration'.md5($agent.$ip.$this->slug.GLOBAL_LANG);

        $refreshTime = 120*1000; // 毫秒
        $plusCache = Yii::$app->cache->exists($key)?Yii::$app->cache->get($key):null;
        if($plusCache && (microtime(true)*1000 - $plusCache['t'] < $refreshTime)) {
            // 频率过高
            // nothing
        } else {
            Yii::$app->cache->set($key, [
                't' => microtime(true)*1000,//访止高频率恶意请求
            ], 3600);

            $modelClass = $this->modelClass;
            $modelClass::updateAllCounters([$this->field => 1], ['slug' => $this->slug]);
        }
    }
}
