<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\widgets\phonecode\PhoneCodePopWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;
use app\widgets\SideBoxListWidget;
use app\assets\LayerAsset;

$this->title = '常见问答';
$links = [];
$links[] = ['label' => '<li class="active"><span>&gt;</span></li>'];
$links[] = ['label' => $this->title];

LayerAsset::register($this);
$pageParam = $dataProvider->pagination->pageParam;
$loadPageUrl = Url::current([$pageParam => null]);//禁止链接中包含page参数
$phoneCodeUrl = Url::to(['/site/phone-code']);
$submitAnswerUrl = Url::to(['/faqs/create']);
$js = <<<EOF
//问题提交功能
$('.ask-cancel').on('click', function() {
    $('#answer').val('');
});

//验证码操作
var layerIndex = null;
$('.ask-confirm').on('click', function() {
    if($('#answer').val() == '') {
        layer.msg('提交的问题不能为空，请重新提交。');
        return false;
    }
    layerIndex = layer.open({
        type: 1
        ,title: false
        //,title: '安全验证'
        ,anim: -1//无动画
        ,shade: false//无背景遮布
        ,area: ['416px', '286px'] //宽高
        ,content: $('#verifycode-tpl'),//模板
    });
});
var getCodeBtn = $("#get-verifycode");//获取验证码按钮
var verifycodePhone = $('#verifycode-phone');//手机号码表单
var verifycodeCode = $('#verifycode-code');//验证码表单
var phoneReg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;//手机号正则
var codeReg = /^\d+$/;
var count = 60; //间隔函数，1秒执行
var InterValObj1; //timer变量，控制时间
var curCount1;//当前剩余秒数
var btnStatus = 1;//按钮状态
$('.turen-faqs').on('click', '#get-verifycode', function() {
    curCount1 = count;		 		 
    var phone = $.trim(verifycodePhone.val());
    if (!phoneReg.test(phone)) {
        layer.msg('请输入有效的手机号码');
        return false;
    }
    if(btnStatus == 0) {
        return false;
    }
    //设置button效果，开始计时
    btnStatus = 0;
    $(this).html( + curCount1 + "秒再获取");
    $.ajax({
        url: '{$phoneCodeUrl}',
        type: 'GET',
        dataType: 'json',
        context: $(this),
        cache: false,
        data: {phone: phone},
        success: function(res) {
            if (res['state']) {
                //console.log(res);
            } else {
                btnStatus = 1;//启用按钮
                layer.msg(res['msg']);
                getCodeBtn.html("重新发送");
            }
        }
    });
    InterValObj1 = window.setInterval(function() {
        if (curCount1 == 0) {
            window.clearInterval(InterValObj1);//停止计时器
            btnStatus = 1;//启用按钮
            getCodeBtn.html("重新发送");
        } else {
            curCount1--;
            getCodeBtn.html( + curCount1 + "秒再获取");
        }
    }, 1000);//启动计时器，1秒执行一次
});
$('.turen-faqs').on('click', '.submit-now', function() {
    var name = $.trim($('#verifycode-name').val());
    if(name == '') {
        layer.msg('用户昵称不能为空');
        return false;
    }
    var answer = $.trim($('#answer').val());
    if(answer == '') {
        layer.msg('提交的问题不能为空，请重新提交。');
        return false;
    }
    var phone = $.trim(verifycodePhone.val());
    if (!phoneReg.test(phone)) {
        layer.msg('请输入有效的手机号码');
        return false;
    }
    var code = $.trim(verifycodeCode.val());
    if(!codeReg.test(code)) {
        layer.msg('请输入手机验证码');
        return false;
    }
    $.ajax({
        url: '{$submitAnswerUrl}',
        type: 'POST',
        dataType: 'json',
        context: $(this),
        cache: false,
        beforeSend: function(xhr) {
            $(this).addClass('loading');
        },
        complete: function(xhr, status) {
            $(this).removeClass('loading');
        },
        data: {phone: phone, name: name, content: answer, code: code},
        success: function(res) {
            if (res['state']) {
                layer.close(layerIndex);
                $('.ask-info .ask-form').fadeOut();
                layer.msg(res['msg'], {icon: 1});//成功
            } else {
                layer.msg(res['msg'], {icon: 5});//失败
            }
        }
    });
});

//加载功能
$('.ask-more').on('click', function() {
    var url = '{$loadPageUrl}';
    var _this = $(this);
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        context: _this,
        cache: false,
        data: {{$pageParam}: _this.data('page')},
        beforeSend: function(xhr) {
            _this.addClass('loading');
        },
        complete: function(xhr, status) {
            _this.removeClass('loading');
        },
        success: function(res) {
            if (res['state']) {
                $('.info-body ul').append(res['msg']);
                $('.info-body .ajax').fadeIn();
                if(res['complete']) {
                    _this.html('已经加载完了').unbind('click');
                } else {
                    _this.data('page', _this.data('page')+1);//分页+1
                }
            } else {
                alert(res['state']);
            }
       }
    });
});
EOF;
$this->registerJs($js);
?>

<?php //只提供了一个弹窗模板，和对应的验证码生成action ?>
<?= PhoneCodePopWidget::widget([
    'templateId' => 'verifycode-tpl',
]); ?>

<div class="faqs-index">
    <div class="container">
        <div class="breadcrumb-box clearfix">
            <span class="location"><b>当前位置：</b></span>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'pagination clearfix'],
                'tag' => 'ul',
                'homeLink' => null,
                'itemTemplate' => "<li>{link}</li>\n",
                //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                'links' => $links,
            ]) ?>
        </div>

        <div class="turen-box">
            <div class="turen-box m2s clearfix">
                <div class="midcontent">
                    <div class="detail-text">
                        <div class="detail-title">
                            <h3>常见问答</h3>
                            <p class="">嘉乐邦，一站式搬家服务。</p>
                        </div>
                        <div class="detail-content ask-info">
                            <div class="ask-form">
                                <div class="ask-answer">
                                    <textarea id="answer" class="jsshow"></textarea>
                                    <div class="ask-foot clearfix">
                                        <div class="fr ask-answer-btn">
                                            <span class="ask-cancel">取消</span>
                                            <span class="ask-confirm">确定</span>
                                        </div>
                                        <p class="tips">您有什么问题，可以在此处进行发布，我们会第一时间进行解答。</p>
                                    </div>
                                </div>
                            </div>

                            <ul class="info-top">
                                <li class="fl"><a class="<?= empty($searchModel->flag)?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => null]) ?>">全部问答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '搬家必答')?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => '搬家必答']) ?>">搬家必答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '最新问答')?'active':'' ?>" href="<?= Url::to(['/faqs/index', 'flag' => '最新问答']) ?>">最新问答</a></li>
                            </ul>
                            <?php
                            if(empty($dataProvider->count)) {
                                echo '<p class="empty">没有任何内容。</p>';
                            } else {
                                echo ListView::widget([
                                    'layout' => "<div class=\"info-body\"><ul>{items}</ul><a class=\"ask-more\" data-page=\"2\" href=\"javascript:;\">点击加载更多</a></div>",
                                    'dataProvider' => $dataProvider,
                                    'summary' => '',//分页概要
                                    'showOnEmpty' => true,
                                    'emptyText' => '没有任何内容。',
                                    'emptyTextOptions' => ['class' => 'empty'],
                                    'options' => ['tag' => false, 'class' => 'list-view'],//整个列表的总class
                                    'itemOptions' => ['tag' => false, 'class' => ''],//每个item上的class
                                    'separator' => "\n",//每个item之间的分隔线
                                    'viewParams' => ['notfirst' => 0],//给模板的额外参数
                                    'itemView' => '_item',//默认参数：$model, $key, $index, $widget
                                    'beforeItem' => '',
                                    'afterItem' => '',
                                    'sorter' => [
                                        'class' => LinkSorter::class,
                                        'options' => ['class' => 'sorter clearfix'],
                                        'attributes' => ['posttime'],
                                    ],
                                    'pager' => [
                                        'class' => LinkPager::class,
                                        'options' => ['class' => 'pagination clearfix'],
                                        //'linkOptions' => ['class' => ''],
                                        'firstPageCssClass' => 'text first',
                                        'lastPageCssClass' => 'text last',
                                        'prevPageCssClass' => 'text prev',
                                        'nextPageCssClass' => 'text next',
                                        'activePageCssClass'=> 'active',
                                        'firstPageLabel' => '首页',
                                        'lastPageLabel' => '末页',
                                        'prevPageLabel' => '上页',
                                        'nextPageLabel' => '下页',
                                    ],
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="sidebox">
                    <div class="tab-sidebox">
                        <div class="tab-sidebox-title">
                            <h3>搬家费用测算</h3>
                        </div>
                        <div class="tab-sidebox-content">
                            <div class="sidebox-block test-price">
                                <p>//http://www.365azw.com/share/jiancai</p>
                                <p>测试</p>
                                <p>测试</p>
                                <p>测试</p>
                            </div>
                        </div>
                    </div>
                    <?= SideBoxListWidget::widget([
                        'style' => 'tab',
                        'htmlClass' => 'about-us',
                        'columnType' => 'block',
                        'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


