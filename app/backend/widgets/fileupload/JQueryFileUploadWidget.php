<?php
/**
 * @author xia.jorry
 * 
 * 注意：文件上传时，需要做上传记录，但取文件时，不需要走任何的验证！
 * 
 *//**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\fileupload;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\jui\InputWidget;
use yii\helpers\Html;
use yii\jui\JuiAsset;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

use app\widgets\fileupload\assets\JQueryFileUploadPlusAsset;
use app\assets\MD5Asset;

/**
 * 图片上传
<div class="form-group merchant-merchant_pic">
    <label for="merchant-merchant_address" class="control-label col-sm-2">测试多文件</label>
    <div class="col-sm-9">
        <?= JQueryFileUploadWidget::widget([
            'model' => $model,
            'attribute' => 'merchant_address',
            'pics' => [],
            'options' => ['class' => 'form-control', 'readonly' => true],
            
            'url' => ['multipletest', 'param' => 'value'],
            'uploadName' => 'merchant_address',
            'fileOptions' => ['accept' => 'image/*', 'multiple' => true],//多文件
            'clientOptions' => [
                'maxFileSize' => 20000000,//200kb
                'dataType' => 'json',
                'acceptFileTypes' => new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                //'maxNumberOfFiles' => 5,
            ],
        ]) ?>
    </div>
</div>

<?= $form->field($model, 'merchant_idcard_image1', [
    'options' => ['class' => 'form-group'],
    'wrapperOptions' => ['class' => 'col-sm-8'],
    'labelOptions' => ['class' => 'control-label col-sm-4'],
    'inputOptions' => ['class' => 'form-control'],
    'horizontalCssClasses' => [
        'error' => 'col-sm-offset-4 col-sm-8',
        'hint' => 'col-sm-8',
    ],
])->widget(JQueryFileUploadWidget::class, [
    'model' => $model,
    'attribute' => 'merchant_idcard_image1',
    'options' => ['class' => 'form-control', 'readonly' => true],
    
    'url' => ['fileupload1', 'param' => 'value'],
    'uploadName' => 'merchant_idcard_image1',
    'fileOptions' => ['accept' => 'image/*', 'multiple' => false],//单图
    'clientOptions' => [
        'maxFileSize' => 200000,//200kb
        'dataType' => 'json',
        'acceptFileTypes' => new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ],
]) ?>
 *
 * 文件上传
 * <?= $form->field($model, 'pic_url', [])->widget(JQueryFileUploadWidget::class, [
        'model' => $model,
        'attribute' => 'pic_url',
        'options' => ['class' => 'form-control', 'readonly' => true],
        'url' => ['fileupload', 'param' => 'value'],
        'uploadName' => 'pic_url',
        'fileOptions' => [
            'accept' => '*',//选择文件时的windows过滤器
            'multiple' => false,//单文件
            'isImage' => false,//非图片文件
        ],//单图
        'clientOptions' => [
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png|ai|txt|xls|xlsx|docx|doc|pdf|zip|rar|tar)$/i'),//限制上传的后缀名
        ],
    ]) ?>
 */
class JQueryFileUploadWidget extends InputWidget
{
    //模型
//     public $model;
//     public $attribute;

    //普通
//     public $name;
//     public $value;

    //input的属性
//     public $options = [];
    //js插件配置
//     public $clientOptions = [];

    public $pics = [];//多图内容

    public $uploadName = 'file';//上传按钮的名称，接收时也是这个名称，默认file
    
    public $fileOptions = [];
    
    /**
     * @var string|array upload route
     */
    public $url;
    
    private $_webIconUrl;
    
    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();//一定要先处理，优化处理了$options和$clientOptions
        
        //初始化配置icon路径
        $this->_webIconUrl = Yii::getAlias('@web/images/icon/');
        
        if(empty($this->url)) {
            throw new InvalidConfigException('"JQueryFileUploadWidget::url" 参数不能为空。');
        }
        
        // 默认配置
        $options = [
            'maxFileSize' => 5000*1024,//默认5M
            'dataType' => 'json',//强制json
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),//默认图片相关文件类型
            'messages' => [
                'acceptFileTypes' => '文件类型不允许，请选择正确的文件类型',
                'maxFileSize' => '文件太大，超过了最大允许值',
                'maxNumberOfFiles' => '文件数量过多',
                'minFileSize' => '文件太小了',
                'uploadedBytes' => '超过设定的文件字节数',
            ],
        ];
        $this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
        
        if (!isset($this->fileOptions['multiple'])) {//默认多文件
            $this->fileOptions['multiple'] = true;
        }
        if (!isset($this->fileOptions['isImage'])) {//默认为图片类型，即可以展示的文件类型
            $this->fileOptions['isImage'] = true;
        }
        $this->clientOptions['url'] = $this->fileOptions['data-url'] = Url::to($this->url);
        $this->clientOptions['autoUpload'] = true;//强制自动上传
        $this->fileOptions['id'] = 'file-btn-'.$this->options['id'];
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        //获取文件相关模型
        $value = ($this->hasModel()) ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        
        switch (true) {
            case (!$this->fileOptions['isImage'] && $this->fileOptions['multiple'])://多文件
                echo $this->render('multiple-file-main', ['pics' => $this->pics]);
                break;
            case (!$this->fileOptions['isImage'] && !$this->fileOptions['multiple'])://单文件
                echo $this->render('file-main', ['pic' => $value]);
                break;
            case ($this->fileOptions['isImage'] && !$this->fileOptions['multiple'])://单图
                echo $this->render('image-main', ['pic' => $value]);
                break;
            default:
                echo $this->render('multiple-image-main', ['pics' => $this->pics]);//多图
            break;
        }

        $this->registerClientScript();
    }
    
    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        JQueryFileUploadPlusAsset::register($view);
        
        if($this->fileOptions['isImage']) {//图片文件
            if($this->fileOptions['multiple']) {
                JuiAsset::register($view);//拖拽
                MD5Asset::register($view);
                $this->addMultipleScriptAndEvents();//多图片文件,js片段
            } else {
                $this->addSimpleScriptAndEvents();//单图文件,js片段
            }
        } else {//非图片文件
            if($this->fileOptions['multiple']) {
                JuiAsset::register($view);//拖拽
                MD5Asset::register($view);
                $this->addMultipleFileScriptAndEvents();//多文件,js片段
            } else {
                $this->addSimpleFileScriptAndEvents();//单文件,js片段
            }
        }

        $id = $this->fileOptions['id'];
        $this->registerClientOptions('fileupload', $id);
        $this->registerClientEvents('fileupload', $id);
    }
    
    //多图
    protected function addMultipleScriptAndEvents()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $notPicUrl= Yii::getAlias('@web/images/').'nopic.jpg';
        $fieldName = ($this->hasModel()) ? Html::getInputName($this->model, $this->attribute) : $this->name;

        //删除操作
        $js = <<<EOF
var id = $("#$id");
id.parents('.multiple-image-main-upload').find('.preview').on('click', '.closebtn', function(){
    $(this).parent().parent().remove();
});
$('.multiple-image-main-upload .preview.ui-sortable').sortable({
    stop: function() {
        //重新排序
        var field = '{$fieldName}';
        $(this).find('.item').each(function(i) {
            $(this).find('input.pic').attr('name', (field + '[' + i + '][pic]'));
            $(this).find('input.txt').attr('name', (field + '[' + i + '][txt]'));
        });
    }
});
EOF;
        $view->registerJs($js);

        if(empty($this->clientEvents['add']))//添加文件时触发回调
            $this->clientEvents['add'] = "function(e, data) {
            data.filepreview = $(e.currentTarget).parents('.multiple-image-main-upload').find('.preview');//预览
            //data.fileprogress = $(e.currentTarget).parents('.multiple-image-main-upload').find('.progress-bar');//进度
        }";

        if(empty($this->clientEvents['processalways']))//添加文件时检查并回调，还未提交
            $this->clientEvents['processalways'] = "function(e, data) {//自身就是以单个文件为对象遍历调用
            var index = data.index;
            var file = data.files[index];
            if (file.error) {
                $.notify(file.name + '：' + file.error, 'error');
                return false;
            }

            //生成占位图
            var link = $('<a>').prop('href', 'javascript:;');
            $('<div>').attr('class', 'thumbnail').attr('id', md5(file.name)).appendTo(link);
            $('<em>').attr('class', 'closebtn').attr('title','删除这张图片').html('×').appendTo(link);
            var li = $('<li>').attr('class', 'item ui-sortable-handle');
            $('<input/>').attr('class', 'pic').prop('type', 'hidden').prop('value', '').prop('name', '').appendTo(li);
            link.appendTo(li);
            var inputTxt = $('<input/>').attr('class', 'txt').prop('type', 'text').prop('value', file.name).prop('name', '');
            $('<p>').attr('class', 'img-name').html(inputTxt).appendTo(li);
            data.filepreview.append(li);
        }";

        /*
         * 进度条体验不好，关闭
        if(empty($this->clientEvents['progressall']))//上传时的全局进度
        $this->clientEvents['progressall'] = "function(e, data) {
            $('.multiple-image-main-upload .loadding').css({'display': 'inline-block'});
            var progress = parseInt(data.loaded / data.total * 100, 10);console.log(progress);
            $(e.currentTarget).parents('.multiple-image-main-upload').find('.progress-bar').show().find('.success').css('width', progress + '%');
        }";
        */
        
        $id = $this->options['id'];
        if(empty($this->clientEvents['done']))//提交上传完毕回调
            $this->clientEvents['done'] = "function(e, data) {
            if(data.result.state) {
                var ret = data.result.msg;
                var id = md5(ret.name);
                var currentItem = data.filepreview.find('div#' + id);
                currentItem.parent().prev().val(ret.objectUrl);
                currentItem.replaceWith($('<img/>').attr('class', 'thumbnail').prop('src', ret.thumbnailUrl));
            } else {
                $.notify(data.result.msg, 'error');//异常
            }
            
            //重新排序
            var field = '{$fieldName}';
            data.filepreview.find('.item').each(function(i) {
                $(this).find('input.pic').attr('name', (field + '[' + i + '][pic]'));
                $(this).find('input.txt').attr('name', (field + '[' + i + '][txt]'));
            });
            
            //data.fileprogress.find('.success').css('width', '0%').parent().hide('slow');//隐藏效果
        }";
                        
        if(empty($this->clientEvents['fail']))//上传之后返回的错误
            $this->clientEvents['fail'] = "function(e, data) {
            $.notify('上传失败，请联系开发者QQ：980522557', 'error');//异常
        }";
    }
    
    //单图
    protected function addSimpleScriptAndEvents()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $notPicUrl = Yii::getAlias('@web').'/images/nopic.jpg';
        
        //删除操作
        $js = <<<EOF
//var input = $("#$id");//同一个表单，多个上传组件，此变量会被污染
var notPicUrl = "$notPicUrl";
$("#$id").parents('.image-main-upload').find('.preview').on('click', '.closebtn', function(){
    $(this).prev().prop('src', notPicUrl);
    $("#$id").val('');
});
EOF;
        $view->registerJs($js);

        if(empty($this->clientEvents['add']))//添加文件时触发回调
        $this->clientEvents['add'] = "function(e, data) {
            data.filepreview = $(e.currentTarget).parents('.image-main-upload').find('.preview');//预览
            //data.fileprogress = $(e.currentTarget).parents('.image-main-upload').find('.progress-bar');//进度
        }";
        
        if(empty($this->clientEvents['processalways']))//添加文件时检查并回调，还未提交
        $this->clientEvents['processalways'] = "function(e, data) {//自身就是以文件为对象遍历调用
            var index = data.index;
            var file = data.files[index];
            if (file.error) {
                $.notify(file.name + '：' + file.error, 'error');
                return false;
            }
            
            //生成占位图
            var link = $('<a>').prop('href', 'javascript:;');
            $('<div>').attr('class', 'thumbnail').appendTo(link);//动态加载效果
            $('<em>').attr('class', 'closebtn').attr('title','删除这张图片').html('×').appendTo(link);//追加
            data.filepreview.html(link);
        }";
        
        /*
         * 进度条体验并不好，关闭
        if(empty($this->clientEvents['progressall']))//上传时的全局进度
        $this->clientEvents['progressall'] = "function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(e.currentTarget).parents('.image-main-upload').find('.progress-bar').show().find('.success').css('width', progress + '%');
        }";
        */
        
        $id = $this->options['id'];
        if(empty($this->clientEvents['done']))//提交上传完毕回调
        $this->clientEvents['done'] = "function(e, data) {
            if(data.result.state) {
                var ret = data.result.msg;
                var link = $('<a>').prop('href', 'javascript:;');
                $('<img/>').attr('class', 'thumbnail').prop('src', ret.thumbnailUrl).appendTo(link);//追加
                $('<em>').attr('class', 'closebtn').attr('title','删除这张图片').html('×').appendTo(link);//追加
                data.filepreview.html(link);//单图覆盖，以防重复操作。。。
                $('#".$id."').val(ret.objectUrl);
            } else {
                $.notify(data.result.msg, 'error');//异常
            }
            
            //data.fileprogress.find('.success').css('width', '0%').parent().hide('slow');//进度条隐藏效果
        }";
        
        if(empty($this->clientEvents['fail']))//上传之后返回的错误
        $this->clientEvents['fail'] = "function(e, data) {
            $.notify('上传失败，请联系开发者QQ：980522557', 'error');//异常
        }";
    }
    
    //多文件
    protected function addMultipleFileScriptAndEvents()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $notPicUrl= Yii::getAlias('@web').'/images/nopic.jpg';
        $fieldName = ($this->hasModel()) ? Html::getInputName($this->model, $this->attribute) : $this->name;
        
        //删除操作
        $js = <<<EOF
var id = $("#$id");
id.parents('.fileupload-buttonbar').find('.fileupload-img-multi-preview').on('click', '.close', function(){
    $(this).parent().remove();
});
$('.fileupload-buttonbar .fileupload-img-multi-preview.ui-sortable').sortable({
    stop: function() {
        //重新排序
        var field = '{$fieldName}';
        $(this).find('.multi-item').each(function(i) {
            $(this).find('input[type=\'hidden\']').attr('name', (field + '[' + i + ']'));
        });
    }
});
EOF;
        $view->registerJs($js);
        
        if(empty($this->clientEvents['add']))//添加文件时触发回调
        $this->clientEvents['add'] = "function(e, data) {
            data.filepreview = $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-img-multi-preview');//预览
            data.fileprogress = $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-multi-progress');//进度
        }";
        
        if(empty($this->clientEvents['processalways']))//添加文件时检查并回调，还未提交
        $this->clientEvents['processalways'] = "function(e, data) {//自身就是以单个文件为对象遍历调用
            var index = data.index, file = data.files[index];
            if (file.error) {
                alert(file.name + '：' + file.error);
                return false;
                //data.filepreview.find('a').append($('<span class=\"text text-danger\"/>').text(file.error));
            }
            //生成点位缩略图，使用空白文件file.png代替
            var item = $('<div>').attr('class', 'multi-item');
            //$('<div>').attr('class', 'progress').append($('<div>').attr('class', 'progress-bar progress-bar-success')).appendTo(item);//总体进度
            $('<img/>').attr('class', 'img-responsive img-thumbnail preview').prop('src', '".($this->_webIconUrl)."' + 'file.png').appendTo(item);
            $('<em>').attr('class', 'close').attr('title','删除这张图片').html('×').appendTo(item);
            data.filepreview.append(item);
            
//             if (index + 1 === data.files.length) {
//                 data.filepreview.find('button').text('Upload').prop('disabled', !!data.files.error);
//             }
        }";
        
        if(empty($this->clientEvents['progressall']))//上传时的全局进度
        $this->clientEvents['progressall'] = "function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-multi-progress .progress').show().find('.progress-bar').css('width', progress + '%');
        }";
        
        $id = $this->options['id'];
        if(empty($this->clientEvents['done']))//提交上传完毕回调
        $this->clientEvents['done'] = "function(e, data) {
            if(data.result.state) {
                //var index = data.index, file = data.files[index];
                //找到上传的缩略图，然后替换img
                var ret = data.result.msg;//逐一替换
                var items = data.filepreview.find('.preview');
                if(items.length > 0) {
                    var item = items.eq(0);
                    var ext = ret.objectUrl.split('.').pop().toLowerCase();
                    item.parent().prepend($('<input/>').prop('type', 'hidden').prop('value', ret.objectUrl).prop('name', ''));//隐藏域
                    item.replaceWith($('<img/>').attr('class', 'img-responsive img-thumbnail').prop('title', data.files[0].name).prop('src', '".($this->_webIconUrl)."' + ext + '.png'));
                }
            } else {
                alert(data.result.msg);//异常
            }
            
            //重新排序
            var field = '{$fieldName}';
            data.filepreview.find('.multi-item').each(function(i) {
                $(this).find('input[type=\'hidden\']').attr('name', (field + '[' + i + ']'));
            });
            data.fileprogress.find('.progress-bar').css('width', '0%').parent().hide('slow');//隐藏效果
        }";
        
        if(empty($this->clientEvents['fail']))//上传之后返回的错误
        $this->clientEvents['fail'] = "function(e, data) {
            console.log('fail');
        }";
    }
    
    //单文件
    protected function addSimpleFileScriptAndEvents()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $notPicUrl= Yii::getAlias('@web').'/images/nopic.jpg';
        
        //删除操作
        $js = <<<EOF
var id = $("#$id");
var notPicUrl = "$notPicUrl";
id.parents('.fileupload-buttonbar').find('.fileupload-img-preview').on('click', '.close', function(){
    $(this).prev().prop('src', notPicUrl);
    id.val('');
});
EOF;
        $view->registerJs($js);
        
        if(empty($this->clientEvents['add']))//添加文件时触发回调
            $this->clientEvents['add'] = "function(e, data) {
            data.filepreview = $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-img-preview');//预览
            data.fileprogress = $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-progress');//进度
        }";
        
        if(empty($this->clientEvents['processalways']))//添加文件时检查并回调，还未提交
        $this->clientEvents['processalways'] = "function(e, data) {//自身就是以文件为对象遍历调用
            var index = data.index, file = data.files[index];
            if (file.error) {
                alert(file.name + '：' + file.error);
                return false;
                //data.filepreview.find('a').append($('<span class=\"text text-danger\"/>').text(file.error));
            }
        }";
        
        if(empty($this->clientEvents['progressall']))//上传时的全局进度
        $this->clientEvents['progressall'] = "function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(e.currentTarget).parents('.fileupload-buttonbar').find('.fileupload-progress .progress').show().find('.progress-bar').css('width', progress + '%');
        }";
        
        $id = $this->options['id'];
        if(empty($this->clientEvents['done']))//提交上传完毕回调
        $this->clientEvents['done'] = "function(e, data) {
            if(data.result.state) {
                var ret = data.result.msg;
                var link = $('<a>').prop('href', 'javascript:;');
                var ext = ret.objectUrl.split('.').pop().toLowerCase();
                $('<img/>').attr('class', 'img-responsive img-thumbnail').prop('title', data.files[0].name).prop('src', '".($this->_webIconUrl)."' + ext + '.png').appendTo(link);//追加
                $('<em>').attr('class', 'close').attr('title','删除这张图片').html('×').appendTo(link);//追加
                data.filepreview.html(link);//单图覆盖，以防重复操作。。。
                            
                $('#".$id."').val(ret.objectUrl);
            } else {
                alert(data.result.msg);//异常
            }
            data.fileprogress.find('.progress-bar').css('width', '0%').parent().hide('slow');//隐藏效果
        }";
        
        if(empty($this->clientEvents['fail']))//上传之后返回的错误
        $this->clientEvents['fail'] = "function(e, data) {
            console.log('fail......JORRY');
        }";
    }
    
    public function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}
