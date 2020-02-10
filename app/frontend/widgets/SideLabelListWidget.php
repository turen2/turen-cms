<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use common\models\cms\Tag;

/**
 * @author jorry
 * 本侧边栏widget可以支持：简单页面，文章，图片，文件下载，视频，碎片等系统默认的模型。
 */
class SideLabelListWidget extends \yii\base\Widget
{
    public $shortColumnClassName;//栏目短类名
    public $htmlClass = '';
    public $title = '请填写标题';
    public $listNum = 10;//列表类型最多显示多少条信息
    public $route = ['/'];

    public function init()
    {
        parent::init();

        //检测参数
        if(empty($this->shortColumnClassName)) {
            throw new InvalidConfigException(self::class.'参数配置有误。');
        }
    }
    
    public function run() {
        $tagList = Tag::TagList($this->shortColumnClassName);
        return $this->render('side-label-list', [
            'htmlClass' => 'label-sidebox '.$this->htmlClass,
            'title' => $this->title,
            'tagList' => array_slice($tagList, 0, $this->listNum),
            'route' => $this->route,
        ]);
    }
}
