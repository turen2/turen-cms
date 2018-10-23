<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\calendar;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\widgets\calendar\assets\CalendarAsset;

/**
 * @author jorry
 */
class CalendarWidget extends \yii\widgets\InputWidget
{
    //配置选项
    public $clientOptions = [];
    
    /**
     * Initializes the widget.
     */
    public function init() {
        parent::init();
        
        //生成唯一id，每个widget都有一个id属性
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        
        $clientOptions = [
            'inputField' => $this->id,
            'ifFormat' => '%Y-%m-%d %H:%M:%S',
            'showsTime' => true,
            'timeFormat' => '24'
        ];
        
        $this->clientOptions = ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        $this->registerClientScript();
        
        $options = ArrayHelper::merge(['id' => $this->id], $this->options);
        
        if ($this->hasModel()) {
            return Html::textInput(Html::getInputName($this->model, $this->attribute), $this->model->getStrTime(), $options);
         } else {
            return Html::textInput($this->name, $this->value, $options);
         }
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        CalendarAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);
        $script = <<<EOF
		Calendar.setup($clientOptions);
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}