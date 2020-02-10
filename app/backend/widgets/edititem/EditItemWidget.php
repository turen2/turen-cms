<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\edititem;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @author jorry
 */
class EditItemWidget extends \yii\widgets\InputWidget
{
    public $primaryKey;//主键字段
    public $url;//ajax url
    
    //配置选项
    public $clientOptions = [];
    
    /**
     * Initializes the widget.
     */
    public function init() {
        
        parent::init();
        
        //生成唯一id，每个widget都有一个id属性
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        $this->options = ArrayHelper::merge(['class' => 'input txt-input30'], $this->options);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        $this->registerClientScript();
        
        $id = $this->model->{$this->primaryKey};
        $value = $this->model->{$this->attribute};
        if ($this->hasModel()) {
            return '<div class="edit-box"><span class="origin">'.$value.'</span>'.Html::activeTextInput($this->model, $this->attribute, $this->options).'<a class="edit-btn" href="javascript:;" data-url="'.$this->url.'" data-id="'.$id.'" onclick="turen.com.editItem(this);"><i class="fa fa-edit"></i></a></div>';
        } else {
            return '<div class="edit-box"><span class="origin">'.$value.'</span>'.Html::textInput($this->id, $this->value, $this->options).'</div><a class="edit-btn" href="javascript:;" data-url="'.$this->url.'" data-id="'.$id.'" onclick="turen.com.editItem(this);"><i class="fa fa-edit"></i></a>';
        }
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        //脚本由ywf.com.editItem处理
        //css由admin.css处理
    }
}