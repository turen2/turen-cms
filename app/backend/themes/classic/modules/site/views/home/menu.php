<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\assets\MenuAsset;
use yii\helpers\Html;
use app\assets\FontAwesomeAsset;
use yii\widgets\Menu;

FontAwesomeAsset::register($this);
MenuAsset::register($this);

$this->title = '菜单栏';
?>
<div class="tGradient"></div>
<div id="scrollmenu">
	<div class="scrollbar">
		<div class="track">
			<div class="thumb">
				<div class="end"></div>
			</div>
		</div>
	</div>
	<div class="viewport">
		<div class="overview">
			<!--scrollbar start-->
			<div class="menubox">
				<div class="title on" onclick="DisplayMenu('leftmenu08');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 界面与专题</div>
				<div id="leftmenu08">
                    <?= Menu::widget([
                        //'itemOptions' => ['class' => ''],
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '后台首页', 'url' => ['/site/home/default'], 'visible' => $roleModel->checkPerm('site/home/default', true)],
                            ['label' => '界面配置', 'url' => ['/site/face-config/setting'], 'visible' => $roleModel->checkPerm('site/face-config/setting', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" id="t1" onclick="DisplayMenu('leftmenu01');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 栏目内容</div>
                <div id="leftmenu01" style="display:none">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '栏目管理', 'url' => ['/cms/column/index'], 'visible' => $roleModel->checkPerm('cms/column/index', true)],
                            ['label' => '类别管理', 'url' => ['/cms/cate/index'], 'visible' => $roleModel->checkPerm('cms/cate/index', true)],
                        ],
                    ]) ?>
					<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '简单页面', 'url' => ['/cms/info/index'], 'visible' => $roleModel->checkPerm('cms/info/index', true)],
                            ['label' => '文章管理', 'url' => ['/cms/article/index'], 'visible' => $roleModel->checkPerm('cms/article/index', true)],
                            ['label' => '图片图集', 'url' => ['/cms/photo/index'], 'visible' => $roleModel->checkPerm('cms/photo/index', true)],
                            ['label' => '文件下载', 'url' => ['/cms/file/index'], 'visible' => $roleModel->checkPerm('cms/file/index', true)],
                            ['label' => '视频管理', 'url' => ['/cms/video/index'], 'visible' => $roleModel->checkPerm('cms/video/index', true)],
                        ],
                    ]) ?>
					<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '碎片集', 'url' => ['/cms/block/index'], 'visible' => $roleModel->checkPerm('cms/block/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu10');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 附加栏目</div>
				<div id="leftmenu10" style="display:none">
                    <?php
                    $items = [];
                    foreach ($diyModels as $diyModel) {
                        $items[] = ['label' => $diyModel['dm_title'], 'url' => ['/cms/master-model/index', 'mid' => $diyModel['dm_id']], 'visible' => $roleModel->checkPerm('cms/master-model/index?mid='.$diyModel['dm_id'], true)];
                    }
                    echo Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => $items,
                    ]) ?>
					<?php if($diyModels) { ?>
					<div class="hr_1"> </div>
					<?php } ?>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '自定义模型', 'url' => ['/cms/diy-model/index'], 'visible' => $roleModel->checkPerm('cms/diy-model/index', true)],
                            ['label' => '自定义字段', 'url' => ['/cms/diy-field/index'], 'visible' => $roleModel->checkPerm('cms/diy-field/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu03');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 产品与订单</div>
				<div id="leftmenu03" style="display:none">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '产品分类', 'url' => ['/shop/product-cate/index'], 'visible' => $roleModel->checkPerm('shop/product-cate/index', true)],
                            ['label' => '产品品牌', 'url' => ['/shop/brand/index'], 'visible' => $roleModel->checkPerm('shop/brand/index', true)],
                            ['label' => '产品管理', 'url' => ['/shop/product/index'], 'visible' => $roleModel->checkPerm('shop/product/index', true)],
                        ],
                    ]) ?>
					<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '订单管理', 'url' => ['/shop/order/index'], 'visible' => $roleModel->checkPerm('shop/order/index', true)],
                            ['label' => '配送设置', 'url' => ['/shop/ship/index'], 'visible' => $roleModel->checkPerm('shop/ship/index', true)],
                            ['label' => '支付设置', 'url' => ['/shop/pay/index'], 'visible' => $roleModel->checkPerm('shop/pay/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu09');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 用户与咨询</div>
				<div id="leftmenu09" style="display:none">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '用户管理', 'url' => ['/user/user/index'], 'visible' => $roleModel->checkPerm('user/user/index', true)],
                            ['label' => '用户收藏', 'url' => ['/user/favorite/index'], 'visible' => $roleModel->checkPerm('user/favorite/index', true)],
                            ['label' => '用户评论', 'url' => ['/user/comment/index'], 'visible' => $roleModel->checkPerm('user/comment/index', true)],

                        ],
                    ]) ?>
					<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'encodeLabels' => false,
                        'items' => [
                            ['label' => '服务订单', 'url' => ['/user/inquiry/index'], 'visible' => $roleModel->checkPerm('user/order/index', true)],
                            ['label' => '问题反馈', 'url' => ['/user/feedback/index'], 'visible' => $roleModel->checkPerm('user/feedback/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="用户组管理" class="menu-wrench group" href="{url}">{label}</a>', 'url' => ['/user/group/index'], 'visible' => $roleModel->checkPerm('user/group/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="用户等级管理" class="menu-wrench level" href="{url}">{label}</a>', 'url' => ['/user/level/index'], 'visible' => $roleModel->checkPerm('user/level/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu02');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 扩展模块</div>
				<div id="leftmenu02" style="display:none">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'encodeLabels' => false,
                        'items' => [
                            ['label' => '导航菜单', 'url' => ['/ext/nav/index'], 'visible' => $roleModel->checkPerm('ext/nav/index', true)],
                            ['label' => '广告管理', 'url' => ['/ext/ad/index'], 'visible' => $roleModel->checkPerm('ext/ad/index', true)],
                            ['label' => '友情链接', 'url' => ['/ext/link/index'], 'visible' => $roleModel->checkPerm('ext/link/index', true)],
                            ['label' => '招聘信息', 'url' => ['/ext/job/index'], 'visible' => $roleModel->checkPerm('ext/job/index', true)],
                            ['label' => '投票管理', 'url' => ['/ext/vote/index'], 'visible' => $roleModel->checkPerm('ext/vote/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="广告位管理" class="menu-wrench ad-type" href="{url}">{label}</a>', 'url' => ['/ext/ad-type/index'], 'visible' => $roleModel->checkPerm('ext/ad-type/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="友情链接类别" class="menu-wrench link-type" href="{url}">{label}</a>', 'url' => ['/ext/link-type/index'], 'visible' => $roleModel->checkPerm('ext/link-type/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu04');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 系统管理</div>
				<div id="leftmenu04" style="display:none;">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '管理员管理', 'url' => ['/sys/admin/index'], 'visible' => $roleModel->checkPerm('sys/admin/index', true)],
                            ['label' => '角色配置', 'url' => ['/sys/role/index'], 'visible' => $roleModel->checkPerm('sys/role/index', true)],
                            ['label' => '多语言管理', 'url' => ['/sys/multilang/index'], 'visible' => $roleModel->checkPerm('sys/multilang/index', true)],
                            ['label' => '系统设置', 'url' => ['/sys/config/setting'], 'visible' => $roleModel->checkPerm('sys/config/setting', true)],
                        ],
                    ]) ?>
    				<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'encodeLabels' => false,
                        'items' => [
                            ['label' => '媒体中心', 'url' => ['/sys/media/index'], 'visible' => $roleModel->checkPerm('sys/media/index', true)],
                            ['label' => '数据库管理', 'url' => ['/sys/db/index'], 'visible' => $roleModel->checkPerm('sys/db/index', true)],
                            ['label' => '级联数据', 'url' => ['/sys/cascade/index'], 'visible' => $roleModel->checkPerm('sys/cascade/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="信息标记管理" class="menu-wrench flag" href="{url}">{label}</a>', 'url' => ['/cms/flag/index'], 'visible' => $roleModel->checkPerm('cms/flag/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="信息来源管理" class="menu-wrench src" href="{url}">{label}</a>', 'url' => ['/cms/src/index'], 'visible' => $roleModel->checkPerm('cms/src/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu06');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 辅助工具</div>
				<div id="leftmenu06" style="display:none;">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '文章抓取', 'url' => ['/tool/spider/index'], 'visible' => $roleModel->checkPerm('tool/spider/index', true)],
                            ['label' => '批量SEO优化', 'url' => ['/tool/seo/index'], 'visible' => $roleModel->checkPerm('tool/seo/index', true)],
                        ],
                    ]) ?>
    				<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'encodeLabels' => false,
                        'items' => [
                            ['label' => '通知用户', 'url' => ['/tool/notify-user/index'], 'visible' => $roleModel->checkPerm('tool/notify-user/index', true)],
                            ['label' => '消息队列', 'url' => ['/tool/notify-group/index'], 'visible' => $roleModel->checkPerm('tool/notify-group/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="消息通知内容" class="menu-wrench notify-content" href="{url}">{label}</a>', 'url' => ['/tool/notify-content/index'], 'visible' => $roleModel->checkPerm('tool/notify-content/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="通知用户来源" class="menu-wrench notify-from" href="{url}">{label}</a>', 'url' => ['/tool/notify-from/index'], 'visible' => $roleModel->checkPerm('tool/notify-from/index', true)],
                        ],
                    ]) ?>
    				<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '手机版', 'url' => ['/tool/mobile/index'], 'visible' => $roleModel->checkPerm('tool/mobile/index', true)],
                            ['label' => '公众号版', 'url' => ['/tool/mp/index'], 'visible' => $roleModel->checkPerm('tool/mp/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu07');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 日志与更新</div>
				<div id="leftmenu07" style="display:none;">
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'items' => [
                            ['label' => '操作日志', 'url' => ['/sys/log/index'], 'visible' => $roleModel->checkPerm('sys/log/index', true)],
                            ['label' => '开发日志', 'url' => ['/sys/dev-log/index'], 'visible' => $roleModel->checkPerm('sys/dev-log/index', true)],
                        ],
                    ]) ?>
					<div class="hr_1"> </div>
                    <?= Menu::widget([
                        'linkTemplate' => '<a target="main" href="{url}">{label}</a>',
                        'encodeLabels' => false,
                        'items' => [
                            ['label' => '教程分类', 'url' => ['/site/help-cate/index'], 'visible' => $roleModel->checkPerm('site/help-cate/index', true)],
                            ['label' => '教程管理', 'url' => ['/site/help/index'], 'visible' => $roleModel->checkPerm('site/help/index', true)],
                            ['label' => '<i class="fa fa-wrench"></i>', 'template' => '<a target="main" title="教程标签管理" class="menu-wrench help-flag" href="{url}">{label}</a>', 'url' => ['/site/help-flag/index'], 'visible' => $roleModel->checkPerm('site/help-flag/index', true)],
                        ],
                    ]) ?>
				</div>
			</div>
			<!--scrollbar end-->
		</div>
	</div>
</div>
<div class="bGradient"></div>