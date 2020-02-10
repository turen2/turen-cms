<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\components;

use Yii;
use common\models\cms\Column;

/**
 * @author jorry
 * 为模板统一添加新特性
 *
 */
class View extends \yii\web\View
{
    public $topUrl = "javascript:history.go(-1);"; // 头部返回链接
    public $topTitle = '';

    public $keywords;
    public $description;

    public $columnModel;//当前栏目
    public $currentModel;//当前主对象

    public function init()
    {
        parent::init();
        
        //some code
    }

    /**
     * 初始化SEO信息
     * 优先级顺序：
     * 手动指定 > 当前模型 > 当前栏目 > 系统默认配置
     */
    public function initSeo()
    {
        if(empty($this->title)) {
            //初始化SEO基础信息
            $this->title = Yii::$app->params['config_seo_title'];

            //如果当前有栏目，则使用栏目的SEO信息
            if(isset($this->currentModel->column) && !is_null($this->currentModel->column)) {
                if(!empty($this->currentModel->column->seotitle)) {
                    $this->title = $this->currentModel->column->seotitle;
                }
            } elseif(!is_null($this->columnModel)) {
                if(!empty($this->columnModel->seotitle)) {
                    $this->title = $this->columnModel->seotitle;
                }
            }

            //当前对象本身的SEO信息
            if(isset($this->currentModel->title) && !empty($this->currentModel->title)) {
                $this->title = $this->currentModel->title;
            }
        }

        if(empty($this->keywords)) {
            //初始化SEO基础信息
            $this->keywords = Yii::$app->params['config_seo_keyword'];

            //如果当前有栏目，则使用栏目的SEO信息
            if(isset($this->currentModel->column) && !is_null($this->currentModel->column)) {
                if(!empty($this->currentModel->column->keywords)) {
                    $this->keywords = $this->currentModel->column->keywords;
                }
            } elseif(!is_null($this->columnModel)) {
                if(!empty($this->columnModel->keywords)) {
                    $this->keywords = $this->columnModel->keywords;
                }
            }

            //当前对象本身的SEO信息
            if(isset($this->currentModel->keywords) && !empty($this->currentModel->keywords)) {
                $this->keywords = $this->currentModel->keywords;
            }
        }

        if(empty($this->description)) {
            //初始化SEO基础信息
            $this->description = Yii::$app->params['config_seo_description'];

            //如果当前有栏目，则使用栏目的SEO信息
            if(isset($this->currentModel->column) && !is_null($this->currentModel->column)) {
                if(!empty($this->currentModel->column->description)) {
                    $this->description = $this->currentModel->column->description;
                }
            } elseif(!is_null($this->columnModel)) {
                if(!empty($this->columnModel->description)) {
                    $this->description = $this->columnModel->description;
                }
            }

            //当前对象本身的SEO信息
            if(isset($this->currentModel->description) && !empty($this->currentModel->description)) {
                $this->description = $this->currentModel->description;
            }
        }
    }
}
