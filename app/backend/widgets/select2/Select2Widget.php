<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets\select2;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use app\widgets\select2\assets\Select2Asset;
use yii\base\InvalidArgumentException;
use app\models\sys\Admin;

/**
 * ```php
 * echo Select2Widget::widget([
 *     'route' => [],
 * ]);
 * ```
 *
 * The following example will use the name property instead:
 * ```php
 * echo Select2Widget::widget([
 *     'route' => [],
 * ]);
 * ```
 *
 * You can also use this widget in an [[yii\widgets\ActiveForm|ActiveForm]] using the [[yii\widgets\ActiveField::widget()|widget()]]
 * method, for example like this:
 *
 * ```php
 * <?= $form->field($model, 'status')->widget(\app\widgets\select2\Select2Widget::classname(), [
 *     // configure additional widget properties here
 * ]) ?>
 * ```
 *
 * @author jorry
 */
class Select2Widget extends \yii\widgets\InputWidget
{
    //配置选项
    public $clientOptions = [];
    public $route = '';//路由
    public $params = [];//路由参数
    
    public $modelClass;//关联表类
    public $primaryKey = 'id';//默认关联表主键
    public $showField = 'name';//要显示的关联表字段
    
    /**
     * Initializes the widget.
     */
    public function init() {
        
        parent::init();
        
        //生成唯一id，每个widget都有一个id属性
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        
        $clientOptions = [
            'theme' => 'default',
            'placeholder' => '请选择一个项目',
            'width' => '100%',
            'allowClear' => true,
            'minimumInputLength' => 0,//最小输入字符
            'allowClear' => true,
            'tags' => false,//是否添加自定义tag
            'tokenSeparators' => [',', '，'],//逗号的方式隔离关键词
        ];
        
        $this->clientOptions = ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        
        $this->registerClientScript();
        
        $options = ArrayHelper::merge(['id' => $this->id, 'class' => ''], $this->options);
        
        //是否初始化
        $items = [];
        
        if(empty($options['multiple'])) {//单选
            if(is_null($this->modelClass)) {//不能为空
                throw new InvalidArgumentException('单选时必须提供表的关联类');
            }
            
            $modelClass = $this->modelClass;
            $primaryKey = $modelClass::primaryKey()[0];
            
            $query = $modelClass::find();
            if($this->hasModel()) {
                $value = $this->model->{$this->attribute};
                if($value && ($model = $query->where([$primaryKey => $value])->one())) {
                    $items = [$value => $model->{$this->showField}];
                }
            } else {
                if($this->value && ($model = $query->where([$this->primaryKey => $this->value])->one())) {
                    $items = [$this->value => $model->{$this->showField}];
                }
            }
        } else {//多选
            $value = $this->model->{$this->attribute};
            $items = is_array($value)?$value:explode(',', $value);
            //$selectedItems = [];
            foreach ($items as $key => $item) {
                $item = trim($item);
                if(empty($item)) continue;
                $items[$item] = $item;
                //$selectedItems[$item] = ['selected' => 'selected'];
                unset($items[$key]);
            }
            //$options['options'] = $selectedItems;
            //$this->model->{$this->attribute} = $items;//重
        }
        
        if ($this->hasModel()) {
            $name = Html::getInputName($this->model, $this->attribute);
            return Html::dropDownList($name, $items, $items, $options);
         } else {
            return Html::dropDownList($this->name, $this->value, $items, $options);
         }
    }
    
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        Select2Asset::register($this->view);
        
        //var_dump(ArrayHelper::merge([$this->route], $this->params));exit;
        $url = Url::to(ArrayHelper::merge([$this->route], $this->params));
        
        $ajax = <<<EOF
        {
            url: '{$url}',
            dataType: 'json',
            //delay: 250,
            data: function (params) {
                return {
                    keyword: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.msg,
                    pagination: {
                        more: (params.page * 20) < data.total_count
                    }
                };
            },
            cache: true
        }
EOF;
        $clientOptions = Json::encode($this->clientOptions);

        $script = <<<EOF
        var config = $clientOptions;
        config.ajax = $ajax;
        $('#{$this->id}').select2(config).on('change', function (e) {
            // nothing
        });
EOF;
        
        $this->view->registerJs($script);//, yii\web\View::POS_READY
    }
}