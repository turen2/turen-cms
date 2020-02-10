<?php

namespace common\tools\like;

use Yii;
use yii\base\InvalidArgumentException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\tools\like\assets\LikeAsset;

/**
 * The following example will use the name property instead:
 * ```php
echo LikeWidget::widget([
    'modelClass' => 'common\tools\like\TestModel',
    'modelId' => 25,
    'upName' => '有用',
    'downName' => '无用',
    'route' => ['/site/default/like'],
]);
 * ```
 *
 * @author jorry
 */
class LikeWidget extends \yii\base\Widget
{
    public $modelClass;

    public $modelId;

    public $upName = '赞'; // 有用

    public $downName = '踩'; // 没用

    public $followName = '收藏'; // 关注，文章

    public $route = [];
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        //各种校验参数
        if(empty($this->modelClass) || is_null($this->modelId) || empty($this->route)) {
            throw new InvalidArgumentException('Parameter Error.');
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();

        $upNum = Like::find()->where(['type' => Like::TYPE_UP, 'model' => $this->modelClass, 'model_id' => $this->modelId])->count('id');
        $downNum = Like::find()->where(['type' => Like::TYPE_DOWN, 'model' => $this->modelClass, 'model_id' => $this->modelId])->count('id');
        $followNum = Like::find()->where(['type' => Like::TYPE_FOLLOW, 'model' => $this->modelClass, 'model_id' => $this->modelId])->count('id');

        $request = Yii::$app->request;
        $agent = $request->getUserAgent();
        $ip = $request->getUserIP();
        $md5 = md5($agent.$ip.$this->modelClass.$this->modelId.Like::TYPE_UP.GLOBAL_LANG);
        $upExist = Like::find()->where(['md5' => $md5])->exists();
        $md5 = md5($agent.$ip.$this->modelClass.$this->modelId.Like::TYPE_DOWN.GLOBAL_LANG);
        $downExist = Like::find()->where(['md5' => $md5])->exists();
        $md5 = md5($agent.$ip.$this->modelClass.$this->modelId.Like::TYPE_FOLLOW.GLOBAL_LANG);
        $followExist = Like::find()->where(['md5' => $md5])->exists();

        $upUrl = Url::to(ArrayHelper::merge($this->route, ['id' => $this->modelId, 'type' => Like::TYPE_UP]));
        $downUrl = Url::to(ArrayHelper::merge($this->route, ['id' => $this->modelId, 'type' => Like::TYPE_DOWN]));
        $followUrl = Url::to(ArrayHelper::merge($this->route, ['id' => $this->modelId, 'type' => Like::TYPE_FOLLOW]));

        $html = '<div id="like-btns">';

        if($this->downName) {
            $html .= Html::a(($downExist?'<i class="iconfont jia-dislike1"></i>':'<i class="iconfont jia-dislike"></i>').$this->downName.'<span class="like-num down-num">'.$downNum.'</span>', 'javascript:;',
                ['data-url' => $downUrl, 'data-type' => Like::TYPE_DOWN, 'data-id' => $this->modelId, 'class' => 'like-btn like-down'.($downExist?' has':'').'']);
        }

        if($this->upName) {
            $html .= Html::a(($upExist?'<i class="iconfont jia-like1"></i>':'<i class="iconfont jia-like2"></i>').$this->upName.'<span class="like-num up-num">'.$upNum.'</span>', 'javascript:;',
                ['data-url' => $upUrl, 'data-type' => Like::TYPE_UP, 'data-id' => $this->modelId, 'class' => 'like-btn like-up'.($upExist?' has':'').'']);
        }

        if($this->followName) {
            $html .= Html::a(($followExist?'<i class="iconfont jia-favourite"></i>':'<i class="iconfont jia-favourite"></i>').$this->followName.'<span class="like-num follow-num">'.$followNum.'</span>', 'javascript:;',
                ['data-url' => $followUrl, 'data-type' => Like::TYPE_FOLLOW, 'data-id' => $this->modelId, 'class' => 'like-btn like-follow'.($followExist?' has':'').'']);
        }

        return $html.'</div>';
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        LikeAsset::register($this->view);
        // $clientOptions = Json::encode($this->clientOptions);

        $script = <<<EOF
            $('#like-btns a.like-btn').on('click', function() {
                if(!$(this).hasClass('has')) {
                    var _this = $(this);
                    var fuc = function(data) {
                        if(data.code == '200') {
                            var num = _this.find('.like-num').html()*1+1;
                            _this.find('.like-num').html(num);
                            _this.addClass('has');
                            
                            // 修改图标
                            if(_this.data('type') == 'UP') {
                                _this.find('i').attr('class', 'iconfont jia-like1');
                            } else if(_this.data('type') == 'DOWN') {
                                _this.find('i').attr('class', 'iconfont jia-dislike1');
                            } else if(_this.data('type') == 'FOLLOW') {
                                _this.find('i').attr('class', 'iconfont jia-favourite');
                            }
                        } else {
                            layer.msg(data.message);
                        }
                    };
                    $.post($(this).data('url'), {type: $(this).data('type'), id: $(this).data('id')}, fuc, "json");
                } else {
                    layer.msg('您已操作，不需要重复操作！');
                }
            })
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}