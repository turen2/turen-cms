<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use common\helpers\Functions;
use backend\models\cms\Column;
use backend\assets\ClipboardAsset;

$updateUrl = Url::to(['/tool/seo/update']);
$batchUpdateUrl = Url::to(['/tool/seo/batch-update']);

ClipboardAsset::register($this);
$js = <<<EOF
    new ClipboardJS('.btn-clipboard');

    $('.btn-clipboard').click(function() {
        $.notify('复制成功', 'success');
    });
    
    // 批量操作
    $('.seo-input.seo-title, .seo-input.seo-slug, .seo-input.seo-keywords, .textdesc.seo-description').on('keyup', function() {
        // 检测按钮状态
        if($(this).val() != $(this).data('content')) {
            var btn = $(this).parents('.table-seo').parent('td').next('td').next('td').find('.op-btn').first();
            btn.removeClass('disabled').addClass('update-btn');
        }
    })
    
    // 更新按钮
    $('.data-table').on('click', '.update-btn', function() {
        var url = '{$updateUrl}';
        var updateBox = $(this).parent().parent().find('.table-seo');
        // console.log(updateBox);
        var data = {
            columnid: updateBox.data('columnid'),
            id: updateBox.data('id'),
            title: updateBox.find('.seo-title').val(),
            slug: updateBox.find('.seo-slug').val(),
            keywords: updateBox.find('.seo-keywords').val(),
            description: updateBox.find('.seo-description').val()
        };
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            context: $(this),
            cache: false,
            data: data,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.notify(XMLHttpRequest.responseText, 'error');
            },
            beforeSend: function() {
                // 更新按钮样式
                $(this).removeClass('update-btn').addClass('disabled').prepend('<i class="fa fa-refresh fa-spin"></i> ');
            },
            complete: function() {
                $(this).html('更新');
            },
            success: function(res) {
                if(res.state) {
                    $.notify('更新成功~', 'success');
                    
                    // ajax成功后，更新所有值
                    updateBox.find('.seo-title').data('content', updateBox.find('.seo-title').val());
                    updateBox.find('.seo-slug').data('content', updateBox.find('.seo-slug').val());
                    updateBox.find('.seo-keywords').data('content', updateBox.find('.seo-keywords').val());
                    updateBox.find('.seo-description').data('content', updateBox.find('.seo-description').val());
                    
                }
           }
        });
    });
    
    // 批量更新
    $('.batch-update-btn').on('click', function() {
        var url = '{$batchUpdateUrl}';
        if($(".data-table input[type='checkbox'][name!='checkid'][name^='checkid']:checked").size() == 0) {
            $.notify('没有任何选中信息！', 'warn');
        } else {
            // 修改选择状态
            var trnobox = $(".data-table input[type='checkbox'][name!='checkid'][name^='checkid']:not(:checked)").parents('tr');
            trnobox.find("input[type='text']").attr('disabled', 'disabled');
            trnobox.find("textarea").attr('disabled', 'disabled');
            
            // 收集数据
            var trbox = $(".data-table input[type='checkbox'][name!='checkid'][name^='checkid']:checked").parents('tr');
            // console.log(trbox.find('.table-seo .seo-title').serializeArray());
            
            var data = {
                columnid: trbox.find('.table-seo').eq(0).data('columnid'),
                id: $(".data-table input[type='checkbox'][name!='checkid'][name^='checkid']:checked").serializeArray(),
                title: trbox.find('.table-seo .seo-title').serializeArray(),
                slug: trbox.find('.table-seo .seo-slug').serializeArray(),
                keywords: trbox.find('.table-seo .seo-keywords').serializeArray(),
                description: trbox.find('.table-seo .seo-description').serializeArray()
            };
            
            // console.log(data);
            // 提交数据
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                context: $(this),
                cache: false,
                data: data,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.notify(XMLHttpRequest.responseText, 'error');
                },
                beforeSend: function() {
                    // 更新按钮样式
                    $(this).removeClass('update-btn').addClass('disabled').prepend('<i class="fa fa-refresh fa-spin"></i> ');
                },
                complete: function() {
                    $(this).html('更新');
                },
                success: function(res) {
                    if(res.state) {
                        $.notify('更新成功~', 'success');
                        trnobox.find("input[type='text']").removeAttr('disabled');
                        trnobox.find("textarea").removeAttr('disabled');
                        $('.data-table .update-btn').removeClass('update-btn').addClass('disabled');
                    }
               }
            });
        }
    });
    
    // 批量推荐
    // $('.batch-recommend-btn').
    
EOF;
$this->registerJs($js);

// $className

$this->title = 'SEO优化管理';
$this->topFilter = $this->render('_filter', ['model' => $searchModel, 'columnModel' => $columnModel]);
if($columnModel) {
    $slugUrl = Functions::ColumnUrl($columnModel->m_column);
    $this->urlLink = '<span class="url-link">访问链接：<a class="btn-clipboard" data-clipboard-text="'.$slugUrl.'" href="javascript:;" title="点击复制">'.$slugUrl.'</a></span>';
}
?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'batchform'],
]); ?>

<style>
    .table-seo {
        width: 100%;
    }
    table.table-seo td {
        border: none;
        padding: 3px 0px;
    }
    table.table-seo .first-column {
        width: 15%;
        text-align: right;
    }
    table.table-seo .seo-domain, table.table-seo .seo-suffix {
        float: left;
        display: inline-block;
        height: 24px;
        line-height: 24px;
    }
    table.table-seo .seo-input.seo-slug {
        width: 57%;
        float: left;
    }
    table.table-seo .seo-input {
        width: 95%;
    }
    table.table-seo .textdesc {
        width: 95%;
    }
    table.data-table .action .op-btn {
        color: white;
        text-decoration: none;
    }
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
	<tr align="left" class="head">
		<td width="4%" class="first-column"><input type="checkbox" name="checkid" id="checkid" onclick="turen.com.checkAll(this.checked);"></td>
		<td width="60%"><?= $dataProvider->sort->link('title', ['label' => '标题']) ?></td>
		<td width="10%"><?= $dataProvider->sort->link('posttime', ['label' => '发布时间']) ?></td>
		<td class="end-column">操作</td>
	</tr>
	<?php foreach ($dataProvider->getModels() as $key => $model) {
	    $options = [
	        'title' => '点击进行显示和隐藏操作',
	        'data-url' => Url::to(['check', 'kid' => $model->id]),
	        'onclick' => 'turen.com.updateStatus(this)',
        ];
		$checkstr = Html::a(($model->status?'显示':'隐藏'), 'javascript:;', $options);
		
		$options = [
    		'data-url' => Url::to(['delete', 'id' => $model->id, 'returnUrl' => Url::current()]),
		    'onclick' => 'turen.com.deleteItem(this, \''.$model->title.'\')',
		];
		$delstr = Html::a('删除', 'javascript:;', $options);
	?>
	<tr align="left" class="data-tr">
		<td class="first-column">
			<input type="checkbox" name="checkid[]" id="checkid[]" value="<?= $model->id; ?>">
		</td>
		<td>
            <?php $slugUrl = Functions::SlugUrl($model, 'slug', Column::MobileColumn($model->columnid)) ?>
            <table class="table-seo" data-columnid="<?= $searchModel->columnid ?>" data-id="<?= $model->id ?>">
                <tr>
                    <td class="first-column"><?= $model->getAttributeLabel('title')?>：</td>
                    <td class="second-column">
                        <?= Html::textInput('title['.$model->id.']', $model->title, ['class' => 'input seo-input seo-title', 'data-content' => $model->title]) ?>
                        <span class="cnote"></span>
                    </td>
                </tr>
                <tr>
                    <td class="first-column"><?= $model->getAttributeLabel('slug')?>：</td>
                    <td class="second-column">
                        <span class="seo-domain"><?= Yii::$app->params['config_site_url'] ?>/<?= Column::MobileColumn($model->columnid) ?>/</span>
                        <?= Html::textInput('slug['.$model->id.']', $model->slug, ['class' => 'input seo-input seo-slug', 'data-content' => $model->slug]) ?>
                        <span class="seo-suffix"><?= Yii::$app->params['config_site_url_suffix'] ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="first-column"><?= $model->getAttributeLabel('keywords')?>：</td>
                    <td class="second-column">
                        <?= Html::textInput('keywords['.$model->id.']', $model->keywords, ['class' => 'input seo-input seo-keywords', 'data-content' => $model->keywords]) ?>
                        <span class="cnote"></span>
                    </td>
                </tr>
                <tr>
                    <td class="first-column"><?= $model->getAttributeLabel('description')?>：</td>
                    <td class="second-column">
                        <?= Html::textarea('description['.$model->id.']', $model->description, ['class' => 'textdesc seo-description', 'data-content' => $model->description]) ?>
                        <span class="cnote"></span>
                    </td>
                </tr>
            </table>
		</td>
		<td><?= Yii::$app->getFormatter()->asDate($model->posttime); ?></td>
		<td class="action end-column">
            <!-- <a class="op-btn" href="javascript:;" onclick="">推荐</a> -->
            <a class="op-btn disabled" href="javascript:;" onclick="">更新</a>
            <a class="btn-clipboard op-btn" data-clipboard-text="<?= $slugUrl ?>" href="javascript:;" title="复制链接">复制链接</a>
        </td>
	</tr>
	<?php } ?>
</table>
<?php ActiveForm::end(); ?>

<?php //判断无记录样式
if(empty($dataProvider->count))
{
	echo '<div class="data-empty">暂时没有相关的记录</div>';
}
?>

<div class="bottom-toolbar clearfix">
	<span class="sel-area">
    	<span class="sel-name">选择：</span> 
    	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
    	<a href="javascript:turen.com.checkAll(false);">反选</a>
    	<span class="op-name">操作：</span>
        <!-- <a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> -->
    	<a href="javascript:;" class="batch-recommend-btn">推荐</a>
    	<a href="javascript:;" class="batch-update-btn">更新</a>
	</span>
	<div class="page">
    	<?= LinkPager::widget([
    	    'pagination' => $dataProvider->getPagination(),
    	    'options' => ['class' => 'page-list', 'tag' => 'div'],
    	    'activePageCssClass' => 'on',
    	    'firstPageLabel' => '首页',
    	    'lastPageLabel' => '尾页',
    	    'nextPageLabel' => '下页',
    	    'prevPageLabel' => '上页',
    	    'linkContainerOptions' => ['tag' => 'span'],
    	]);
    	?>
    </div>
</div>

<div class="quick-toolbar">
	<div class="qiuck-warp">
		<div class="quick-area">
    		<span class="sel-area">
            	<span class="sel-name">选择：</span> 
            	<a href="javascript:turen.com.checkAll(true);">全选</a> - 
            	<a href="javascript:turen.com.checkAll(false);">反选</a>
            	<span class="op-name">操作：</span>
            	<!-- <a href="javascript:turen.com.batchSubmit('<?=Url::to(['batch', 'type' => 'delete'])?>', 'batchform');">删除</a> -->
                <a href="javascript:;" class="batch-recommend-btn">推荐</a>
    	        <a href="javascript:;" class="batch-update-btn">更新</a>
            	<span class="total">共 <?= $dataProvider->getTotalCount() ?> 条记录</span>
        	</span>
			<div class="page-small">
			<?= LinkPager::widget([
			    'pagination' => $dataProvider->getPagination(),
			    'options' => ['class' => 'page-list', 'tag' => 'div'],
			    'activePageCssClass' => 'on',
			    'firstPageLabel' => '首页',
			    'lastPageLabel' => '尾页',
			    'nextPageLabel' => '下页',
			    'prevPageLabel' => '上页',
			    'linkContainerOptions' => ['tag' => 'span'],
			]);
			?>
			</div>
		</div>
		<div class="quick-area-bg"></div>
	</div>
</div>
<p class="cp tc"><?= Yii::$app->params['config_copyright'] ?></p>