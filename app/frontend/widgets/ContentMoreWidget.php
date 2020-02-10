<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use common\models\cms\Column;

/**
 * @author jorry
 * 本侧边栏widget可以支持：文章，图片，文件下载，视频等系统默认的模型。
 */
class ContentMoreWidget extends \yii\base\Widget
{
    public $htmlClass = '';
    public $title = '请填写标题';
    public $moreLink = '';

    public $columnType;//'article','photo','file','product','video'还有自定义模型

    public $flagName;//目前支持：推荐，置顶，最新，最热，相关，还看，六个标签
    public $columnId;//文章图片视频文件产品对应的columnid
    public $listNum = 10;//列表类型最多显示多少条信息
    public $route = ['/'];

    public function init()
    {
        parent::init();

        //检测参数
        if(empty($this->columnType)) {
            throw new InvalidConfigException(self::class.'参数配置有误。');
        }
    }

    public function run() {
        $boxlist = $this->boxList();
        return $this->render('content-more', [
            'htmlClass' => 'content-more '.$this->htmlClass,//组合通用class名
            'title' => $this->title,
            'moreLink' => $this->moreLink,
            'boxlist' => $boxlist,
            'route' => $this->route,
        ]);
    }

    /**
     * 列表类型内容列表
     * @return mixed
     * @throws InvalidConfigException
     */
    protected function boxList()
    {
        //內容生成
        $className = Column::ColumnConvert('mask2class', $this->columnType);
        if(empty($this->columnId) || empty($className)) {
            throw new InvalidConfigException(self::class.'参数columnId或$className配置有误。');
        }

        $query = $className::find()->where(['columnid' => $this->columnId]);
        if(in_array($this->flagName, ['推荐', '置顶', '相关', '还看'])) {
            $query->andFilterWhere(['like', 'flag', $this->flagName])->orderBy(['orderid' => SORT_DESC]);
        } elseif($this->flagName == '最新') {
            $query->orderBy(['posttime' => SORT_DESC]);
        } elseif($this->flagName == '最热') {
            $query->orderBy(['hits' => SORT_DESC]);
        }
        $query->limit($this->listNum);

        //echo $query->createCommand()->getRawSql();exit;

        return $query->asArray()->all();
    }
}
