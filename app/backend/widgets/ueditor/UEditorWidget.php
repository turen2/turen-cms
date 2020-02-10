<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\ueditor;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\InputWidget;

class UEditorWidget extends InputWidget
{
    //配置选项，参阅Ueditor官网文档(定制菜单等)
    public $clientOptions = [];

    //默认配置
    protected $_options;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (isset($this->options['id'])) {
            $this->id = $this->options['id'];
        } else {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        }
        
        $this->_options = [
            'serverUrl' => Url::to(['upload']),
            'initialFrameWidth' => '100%',
            'initialFrameHeight' => '400',
            'lang' => 'zh-cn',//(strtolower(Yii::$app->language) == 'en-us') ? 'en' : 'zh-cn'
            //定制菜单
            'toolbars' => [
                [
                    'fullscreen', 'source', '|',
                    'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                    'indent', 'rowspacingtop', 'rowspacingbottom', 'lineheight', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                    'paragraph', 'fontfamily', 'fontsize', '|',
                    'link', 'unlink', 'anchor', '|',
                    'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'insertvideo', 'attachment', 'map', '|',
                    'pagebreak', 'template', 'background', '|',
                    //'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols',  '|',
                    'date', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', 'inserttable',
                ],
            ]
        ];
        
        if(isset($this->clientOptions['toolbars'])) {
            $this->_options['toolbars'] = $this->clientOptions['toolbars'];
            $this->clientOptions['toolbars'] = [];
        }
        
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
        
        parent::init();
    }

    public function run()
    {
        $this->registerClientScript();
        
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['id' => $this->id, 'class' => 'ueditor-textarea']);
        } else {
            return Html::textarea($this->id, $this->value, ['id' => $this->id, 'class' => 'ueditor-textarea']);
        }
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        UEditorAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);
        //commands: {…}, options: {…}, shortcutkeys: {…}, inputRules
        $script = "var ue = UE.getEditor('" . $this->id . "', " . $clientOptions . ");/*console.log(ue);*/";
        $this->view->registerJs($script, View::POS_READY);
        
        //显示ueditor的textarea使validation验证有效
//         $js = "$('.ueditor-textarea').css('display', 'block');";
//         $this->view->registerJs($js, View::POS_READY);
    }
}
