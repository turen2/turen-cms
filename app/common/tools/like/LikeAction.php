<?php

namespace common\tools\like;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\Response;
use yii\web\HttpException;

/**
 * Class LikeAction
 * @package common\tools\like
 * ```php
public function actions()
{
    return [
        'like' => [
            'class' => LikeAction::class,
            'modelClass' => 'common\tools\like\TestModel',
            'id' => Yii::$app->getRequest()->post('id'),
            'type' => Yii::$app->getRequest()->post('type'),
        ]
    ];
}
 * ```
 */
class LikeAction extends Action
{
    public $modelClass;

    public $id;

    public $type;

    public function init()
    {
        parent::init();

        Yii::$app->response->format = Response::FORMAT_JSON;

        //保证以ajax进行访问
        if(!Yii::$app->request->getIsAjax()) {
            throw new HttpException('LinkAction->Request Type Error, not ajax');
        }

        //各种校验参数
        if(empty($this->modelClass) || empty($this->type) || is_null($this->id)) {
            throw new InvalidArgumentException('Parameter Error.');
        }
    }

    public function run()
    {
        if($md5 = $this->checkIllegalRequest()) {
            if($this->type == Like::TYPE_FOLLOW) { // 关注，收藏
                if(!Yii::$app->user->isGuest) {
                    if(!Like::find()->where(['user_id' => Yii::$app->user->id, 'model' => $this->modelClass, 'model_id' => $this->id])->exists()) {
                        Like::PlusOne($this->modelClass, $this->id, $md5, $this->type);
                        return [
                            'code' => 200,
                            'data' => [],
                        ];
                    } else {
                        return [
                            'code' => 416,
                            'message' => '已重复请求',
                        ];
                    }
                } else {
                    return [
                        'code' => 401,
                        'message' => '您还未登录',
                    ];
                }
            } else {
                Like::PlusOne($this->modelClass, $this->id, $md5, $this->type);
                return [
                    'code' => 200,
                    'data' => [],
                ];
            }
        } else {
            return [
                'code' => 500,
                'message' => '您已经操作过了',
            ];
        }
    }

    /**
     * @return bool
     *
     * md5(代理+IP+操作的模型+模型id+点赞类型+语言) 联合唯一
     * 缓存时间控制
     */
    protected function checkIllegalRequest()
    {
        $request = Yii::$app->request;

        $agent = $request->getUserAgent();
        $ip = $request->getUserIP();

        $md5 = md5($agent.$ip.$this->modelClass.$this->id.$this->type.GLOBAL_LANG);//代理+IP+操作的模型+模型id+点赞类型+语言
        $key = 'like_duration'.$md5; // md5($agent.$ip.$this->type);

        $refreshTime = 3*3600*1000; // 毫秒

        $likeCache = Yii::$app->cache->exists($key)?Yii::$app->cache->get($key):null;

        // $likeCache 表示首次一定通行
        // $likeCache['md5'] == $md5 表示同一个对象，不允许再点赞
        // (microtime(true)*1000 - $likeCache['t'] < $refreshTime) 表示换浏览器攻击，时间限制
        if($likeCache && (microtime(true)*1000 - $likeCache['t'] < $refreshTime)) {
            // 频率过高
            return false;
        } else {
            Yii::$app->cache->set($key, [
                't' => microtime(true)*1000,//访止高频率恶意请求
                'md5' => $md5,//不记录刷新动作
            ], 3600);

            return $md5;
        }
    }
}