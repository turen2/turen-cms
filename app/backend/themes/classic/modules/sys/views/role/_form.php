<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\widgets\Tips;
use app\assets\ValidationAsset;
use app\models\sys\Role;
use app\helpers\BackCommonHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\sys\Role */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$rules = $messages = [];
$rules[Html::getInputName($model, 'role_name')] = ['required' => true];
$rules = Json::encode($rules);
$messages = Json::encode($messages);
$js = <<<EOF
var validator = $("#submitform").validate({
	rules: {$rules},
	messages: {$messages},
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});

$('.selectall').on('click', function() {
    $(this).parents('.second-column').find("input[type='checkbox']").attr('checked', true);
});
$('.selectnotall').on('click', function() {
    $(this).parents('.second-column').find("input[type='checkbox']").attr('checked', false);
});
EOF;
$this->registerJs($js);
?>

<?= Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]) ?>

<?php $form = ActiveForm::begin([
    'enableClientScript' => false,
    'options' => ['id' => 'submitform'],
]); ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="role-form form-table">
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('role_name')?><?php if($model->isAttributeRequired('role_name')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeInput('text', $model, 'role_name', ['class' => 'input']) ?>
    			<span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('note')?><?php if($model->isAttributeRequired('note')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?= Html::activeTextarea($model, 'note', ['class' => 'textarea']) ?>
    			<span class="cnote"></span>
    		</td>
    	</tr>
    	<tr>
    		<td class="first-column"><?= $model->getAttributeLabel('status')?><?php if($model->isAttributeRequired('status')) { ?><span class="maroon">*</span><?php } ?></td>
    		<td class="second-column">
    			<?=
    			Html::activeRadioList($model, 'status', [
    			    Role::STATUS_ON => '有效',
    			    Role::STATUS_OFF => '无效',
			    ], [
			        'separator' => '&nbsp;&nbsp;&nbsp;'
			    ]) ?>
    		</td>
    	</tr>
        <tr>
            <td class="first-column">界面与专题管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>后台首页</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/home/default', '首页查看') ?></span>
                </div>
                <div class="purview-title">
                    <strong>界面配置</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/face-config/setting', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/face-config/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>专题管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/topic/batch', '批量操作') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
    	<tr>
			<td class="first-column">模型权限管理：</td>
			<td class="second-column">
				<div class="purview-title">
                    <strong>栏目管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/index', '栏目查看') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/create', '栏目新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/fileupload', '单图上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>类别管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>单面信息管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/fileupload', '单图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>列表信息管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/get-tags', 'ajax标签列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>图片信息管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/get-tags', 'ajax标签列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>视频管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/get-tags', 'ajax标签列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>下载管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/get-tags', 'ajax标签列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>碎片数据管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>标记管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>信息来源管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/src/index', '查看/新增/编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/src/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/src/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/src/quick-move', '快捷移动') ?></span>
                </div>
                <div class="purview-title">
                    <strong>自定义模型</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/validate-name', 'ajax验证模型名称') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/validate-tbname', 'ajax验证模型表名') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-model/validate-title', 'ajax验证模型标题') ?></span>
                </div>
                <div class="purview-title">
                    <strong>自定义字段</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/column-check-box-list', 'ajax获取栏目列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/validate-name', 'ajax验证字段名称') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'cms/diy-field/validate-title', 'ajax验证字段标题') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">附加模型权限管理：</td>
            <td class="second-column">
                <?php foreach ($diyModels as $diyModel) { ?>
                    <div class="purview-title">
                        <strong><?= $diyModel['dm_title'] ?></strong>
                    </div>
                    <div class="purview-list">
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/index?mid='.$diyModel['dm_id'], '查看列表') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/create?mid='.$diyModel['dm_id'], '新增') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/delete?mid='.$diyModel['dm_id'], '删除') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/update?mid='.$diyModel['dm_id'], '编辑') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/check?mid='.$diyModel['dm_id'], '修改状态') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/edit-item?mid='.$diyModel['dm_id'], '简单编辑') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/quick-move?mid='.$diyModel['dm_id'], '快捷移动') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/batch?mid='.$diyModel['dm_id'], '批量操作') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/get-tags?mid='.$diyModel['dm_id'], 'ajax标签列表') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/fileupload?mid='.$diyModel['dm_id'], '缩略图上传') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/multiple-fileupload?mid='.$diyModel['dm_id'], '多图上传') ?></span>
                        <span><?= BackCommonHelper::CheckPermBox($model, 'cms/master-model/ueditor?mid='.$diyModel['dm_id'], '编辑器图片上传') ?></span>
                    </div>
                <?php } ?>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">拓展模块管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>导航菜单管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/fileupload', '缩略图上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>广告位管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>广告管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/fileupload', '缩略图上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>友情链接组管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/check', '状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>友情链接管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/fileupload', '缩略图上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>招聘管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>投票管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">产品与订单管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>产品分类</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product-cate/fileupload', '缩略图上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>产品管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/product/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>产品属性</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/attribute/edit-item', '简单编辑') ?></span>
                </div>
                <div class="purview-title">
                    <strong>产品品牌</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'shop/brand/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">用户与咨询管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>用户管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/user/recycle', '回收站') ?></span>
                </div>
                <div class="purview-title">
                    <strong>收藏管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/favorite/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/favorite/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/favorite/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>用户评论</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/comment/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>服务订单</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/inquiry/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/inquiry/view', '查看详情') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'user/inquiry/edit', '编辑') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">系统权限管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>管理员管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/check', '修改状态') ?></span>
                </div>
                <div class="purview-title">
                    <strong>系统设置管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/config/setting', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/config/batch', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/config/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/config/fileupload', '缩略图上传') ?></span>
                </div>

                <div class="purview-title">
                    <strong>角色管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/check', '修改状态') ?></span>
                </div>
                <div class="purview-title">
                    <strong>多语言管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/quick-move', '上下排序') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/multilang-tpl/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>模板管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/template-select', 'ajax获取模板列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">工具权限管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>全局选择器</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'tool/selector/*', '占位') ?></span>
                </div>
                <div class="purview-title">
                    <strong>SEO管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'tool/seo/*', '占位') ?></span>
                </div>
                <div class="purview-title">
                    <strong>抓取管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'tool/spider/*', '占位') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">公共资源管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>伪链接生成</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'com/link/pinyin', '伪链接生成') ?></span>
                </div>
                <div class="purview-title">
                    <strong>快捷链接</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/lnk/index', '查看/新增/编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/lnk/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/lnk/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/lnk/quick-move', '快捷移动') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="first-column">日志与更新管理：</td>
            <td class="second-column">
                <div class="purview-title">
                    <strong>操作日志管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/log/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/log/view', '详情') ?></span>
                </div>
                <div class="purview-title">
                    <strong>开发日志管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/dev-log/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/dev-log/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'sys/dev-log/ueditor', '编辑器图片上传') ?></span>
                </div>
                <div class="purview-title">
                    <strong>帮助类别管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/quick-move', '快捷移动') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-cate/batch', '批量操作') ?></span>
                </div>
                <div class="purview-title">
                    <strong>帮助信息管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/index', '查看列表') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/create', '新增') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/update', '编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/check', '修改状态') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/edit-item', '简单编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/fileupload', '缩略图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/multiple-fileupload', '多图上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/ueditor', '编辑器图片上传') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help/get-tags', 'ajax标签列表') ?></span>
                </div>
                <div class="purview-title">
                    <strong>帮助标记管理</strong>
                </div>
                <div class="purview-list">
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-flag/index', '查看/新增/编辑') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-flag/delete', '删除') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-flag/batch', '批量操作') ?></span>
                    <span><?= BackCommonHelper::CheckPermBox($model, 'site/help-flag/quick-move', '快捷移动') ?></span>
                </div>
                <div class="purviewSel">
                    <a href="javascript:;" class="selectall">全选</a>&nbsp;&nbsp;
                    <a href="javascript:;" class="selectnotall">反选</a>
                </div>
            </td>
        </tr>
    	<tr class="nb">
    		<td></td>
    		<td>
    			<div class="form-sub-btn">
            		<?= Html::submitButton('提交', ['class' => 'submit', 'id' => 'submit-btn']) ?>
            		<?= Html::input('button', 'backName', '返回', ['class' => 'back', 'onclick' => 'location.href="'.Url::to(['index']).'"']) ?>
            	</div>
    		</td>
    	</tr>
	</table>
<?php ActiveForm::end(); ?>