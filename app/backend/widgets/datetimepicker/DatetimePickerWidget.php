<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\datetimepicker;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\widgets\datetimepicker\assets\DatetimePickerAsset;

/**
 * @author jorry
 * 注意：
 * 'model' => $model,必填属性
 * 'attribute' => 'posttime',必填属性
 * 'value' => '',必填属性
 */
class DatetimePickerWidget extends \yii\widgets\InputWidget
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
            'format' => 'Y-m-d H:i:s',
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
            $this->model->{$this->attribute} = $this->value;
            return Html::textInput(Html::getInputName($this->model, $this->attribute), '', $options);
         } else {
            return Html::textInput($this->name, $this->value, $options);
         }
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        DatetimePickerAsset::register($this->view);
        
        $clientOptions = Json::encode($this->clientOptions);
        $script = <<<EOF
            $.datetimepicker.setLocale('ch');
            $('#{$this->id}').datetimepicker({$clientOptions});
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}