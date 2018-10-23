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

/* @var $this yii\web\View */
/* @var $model app\models\sys\Role */
/* @var $form yii\widgets\ActiveForm */

ValidationAsset::register($this);

$this->registerJs('
var validator = $("#submitform").validate({
	rules: {
		"'.Html::getInputName($model, 'role_name').'": {
			required: true,
		}
	},
    errorElement: "p",
	errorPlacement: function(error, element) {
		error.appendTo(element.parent());
	}
});
');
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
			<td class="first-column">模块权限：</td>
			<td class="second-column">
				<div class="purview-title">
					<strong>栏目内容管理</strong>
				</div>
				<div class="purview-list">
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/column/*', '栏目管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/cate/*', '类别管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/info/*', '单页信息管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/article/*', '列表信息管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/photo/*', '图片信息管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/video/*', '视频管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/file/*', '下载管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/block/*', '碎片数据管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/flag/*', '标记管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/src/*', '信息来源管理') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/model/*', '自定义模型') ?></span>
					<span><?= BackCommonHelper::CheckPermBox($model, 'cms/field/*', '自定义字段') ?></span>
				</div>
				<div class="purview-title">
					<strong>模块扩展管理</strong></div>
				<div class="purview-list">
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/nav/*', '导航菜单') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad/*', '广告管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/ad-type/*', '广告位管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/link/*', '友情链接管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/link-type/*', '友情链接组管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/job/*', '招聘管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'ext/vote/*', '投票管理') ?></span>
				</div>
				<div class="purview-title">
					<strong>电商管理</strong></div>
				<div class="purview-list">
    				<span><?= BackCommonHelper::CheckPermBox($model, 'shop/default/*', '管理测试') ?></span>
				</div>
				<div class="purview-title">
					<strong>系统管理</strong></div>
				<div class="purview-list">
    				<span><?= BackCommonHelper::CheckPermBox($model, 'sys/admin/*', '管理员管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'sys/config/*', '配置管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'sys/log/*', '操作日志') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'sys/role/*', '角色管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'sys/template/*', '模板管理') ?></span>
				</div>
				<div class="purview-title">
					<strong>工具管理</strong></div>
				<div class="purview-list">
    				<span><?= BackCommonHelper::CheckPermBox($model, 'tool/selector/*', '全局选择器') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'tool/seo/*', 'SEO管理') ?></span>
    				<span><?= BackCommonHelper::CheckPermBox($model, 'tool/spider/*', '抓取管理') ?></span>
				</div>
				<div class="purviewSel">
					<a href="javascript:;" onclick="SelModel(true)">全选</a>&nbsp;&nbsp;
					<a href="javascript:;" onclick="SelModel(false)">反选</a>
				</div>
			</td>
		</tr>
		<tr class="nb">
			<td class="first-column">&nbsp;</td>
			<td class="second-column"><ul class="tips-list">
					<li>选中【查看】权限，即有该栏目内容信息列表页查看权限，不选择则栏目内容在管理列表中会被隐藏</li>
					<li>选中【添加】权限，即有添加下级栏目与栏目内容权限</li>
					<li>选中【修改】权限，即有信息列表管理页审核权限与栏目和栏目内容修改权限</li>
					<li>选中【删除】权限，即有该栏目与栏目内容删除权限</li>
				</ul></td>
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