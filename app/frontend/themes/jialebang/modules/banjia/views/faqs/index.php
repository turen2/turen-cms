<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
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
$url = Url::current([$pageParam => null]);//禁止链接中包含page参数
$js = <<<EOF
//问题提交功能
$('.ask-cancel').on('click', function() {
    $('#answer').val('');
});
$('.ask-confirm').on('click', function() {
    layer.open({
        type: 1
        ,title: false
        //,title: '安全验证'
        ,anim: -1//无动画
        ,shade: false
        ,area: ['420px', '300px'] //宽高
        ,content: $('#phone-code-tpl'),
    });
});

//加载功能
$('.ask-more').on('click', function() {
    var url = '{$url}';
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

<div id="phone-code-tpl" style="display: none;">
    <form action="" class="phone-code-form">
        <h3>请验证手机验证码</h3>
        <div class="form-items">
            <div class="items clearfix">
                <label for="" class="fl">您的称呼 : <span>*</span></label>
                <div class="fl">
                    <input type="text" name="name" placeholder="请输入您的称呼" />
                </div>
            </div>
            <span class="cue"></span>
        </div>
        <div class="form-items">
            <div class="items clearfix">
                <label for="" class="fl">手机号码 : <span>*</span></label>
                <div class="fl">
                    <input type="number" name="phone" placeholder="填写手机号码" />
                </div>
            </div>
            <span class="cue"></span>
        </div>
        <div class="form-items">
            <div class="items clearfix">
                <label for="" class="fl">手机验证码 : <span>*</span></label>
                <div class="fl">
                    <input type="number" name="phoneCode" placeholder="手机验证码" />
                </div>
                <a href="">获取验证码</a>
            </div>
            <span class="cue"></span>
        </div>
        <div class="refer clearfix">
            <a href="javascript:;" class="submit-now fr">马上提交</a>
        </div>
    </form>
</div>

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

                            <div style="display: none;">
                                <?php $form = ActiveForm::begin(); ?>
                                <?= $model->getAttributeLabel('question')?>
                                <?= Html::activeInput('text', $model, 'question') ?>
                                <?= $model->getAttributeLabel('nickname')?>
                                <?= Html::activeInput('text', $model, 'nickname') ?>
                                <?= $model->getAttributeLabel('phone')?>
                                <?= Html::activeInput('text', $model, 'phone') ?>
                                <?= $model->getAttributeLabel('phoneCode')?>
                                <?= Html::activeInput('text', $model, 'phoneCode') ?>
                                <?= $model->getAttributeLabel('verifyCode')?>
                                <?= Html::activeInput('text', $model, 'verifyCode') ?>
                                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                                <?php ActiveForm::end(); ?>
                            </div>

                            <ul class="info-top">
                                <li class="fl"><a class="<?= empty($searchModel->flag)?'active':'' ?>" href="<?= Url::to(['/banjia/faqs/index', 'flag' => null]) ?>">全部问答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '搬家必答')?'active':'' ?>" href="<?= Url::to(['/banjia/faqs/index', 'flag' => '搬家必答']) ?>">搬家必答</a></li>
                                <li class="fl"><a class="<?= ($searchModel->flag == '最新问答')?'active':'' ?>" href="<?= Url::to(['/banjia/faqs/index', 'flag' => '最新问答']) ?>">最新问答</a></li>
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


