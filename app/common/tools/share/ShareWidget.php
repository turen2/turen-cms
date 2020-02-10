<?php

namespace common\tools\share;

use Yii;
use common\tools\share\assets\ShareAsset;
use yii\helpers\Json;

/**
 * The following example will use the name property instead:
 * ```php
echo ShareWidget::widget([
    'title' => '分享至：',
]);
 * ```
 *
 * @author jorry
 */
class ShareWidget extends \yii\base\Widget
{
    public $title = '分享至';

    // ['weibo','qq','wechat','tencent','douban','qzone','linkedin','diandian','facebook','twitter','google']
    public $clientOptions = ['qzone', 'qq', 'weibo','wechat'];

    public $images = [];
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        //
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();

        $imgList = '';

        if($this->images) {
            foreach ($this->images as $imgsrc) {
                $imgList .= '<li><img class="share-ok" src="'.$imgsrc.'" /></li>';
            }
        } else {
            $imgList = '<li><img class="share-ok" src="'.Yii::$app->aliyunoss->getObjectUrl(Yii::$app->params['config_frontend_logo'], true).'" /></li>';
        }

        $imgList = '<ul style="display: none;">'.$imgList.'</ul>';

        return '<div class="share-btns">'.$imgList.'<div class="share-btn2"><span class="share-title">'.$this->title.'</span></div></div>';
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        ShareAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);

        $script = <<<EOF
            var hhead = $(document.head);
            $('.share-btn2').share({
                url: location.href,
                site_url: location.origin,
                source: hhead.find('[name=site], [name=Site]').attr('content') || document.title,
                title: hhead.find('[name=title], [name=Title]').attr('content') || document.title,
                description: hhead.find('[name=description], [name=Description]').attr('content') || '',
                image: $('img:first').prop('src') || '',
                imageSelector: 'body img.share-ok',
    
                weiboKey: '',
    
                wechatQrcodeTitle: '微信扫一扫：分享',
                wechatQrcodeHelper: '<p>微信里点“发现”，扫一下</p><p>二维码便可将本文分享至朋友圈。</p>',
                wechatQrcodeSize: 100,
    
                mobileSites: [],
                sites: {$clientOptions}, // ['weibo','qq','wechat','tencent','douban','qzone','linkedin','diandian','facebook','twitter','google'],
                disabled: [],
                initialized: false
            });
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}