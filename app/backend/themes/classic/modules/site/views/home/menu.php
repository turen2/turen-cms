<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\assets\MenuAsset;
use yii\helpers\Html;
use app\assets\FontAwesomeAsset;

FontAwesomeAsset::register($this);
MenuAsset::register($this);

$this->title = '菜单栏';
?>

<div class="quick-btn"> 
    <span class="quick-btn-left">
    	<?= Html::a('<i class="fa fa-list"></i> 添文章', ['/cms/article/index'], ['target' => 'main'])?>
    </span> 
    <span class="quick-btn-right">
    	<?= Html::a('<i class="fa fa-photo"></i> 添图片', ['/cms/photo/index'], ['target' => 'main'])?>
    </span> 
</div>

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
					<?= Html::a('后台首页', ['/site/home/default'], ['target' => 'main'])?>
					<?= Html::a('界面配置', ['/site/face/config'], ['target' => 'main'])?><!-- 典型的站点配置 -->
					<?= Html::a('专题管理', ['/site/topic/index'], ['target' => 'main'])?><!-- 典型的站点专题 -->
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" id="t1" onclick="DisplayMenu('leftmenu01');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 栏目内容</div>
				<div id="leftmenu01" style="display:none"> 
					<?= Html::a('栏目管理', ['/cms/column/index'], ['target' => 'main'])?>
					<?= Html::a('类别管理', ['/cms/cate/index'], ['target' => 'main'])?>
					<div class="hr_1"> </div>
					<?= Html::a('单页', ['/cms/info/index'], ['target' => 'main'])?>
					<?= Html::a('文章', ['/cms/article/index'], ['target' => 'main'])?>
					<?= Html::a('图片', ['/cms/photo/index'], ['target' => 'main'])?>
					<?= Html::a('下载', ['/cms/file/index'], ['target' => 'main'])?>
					<?= Html::a('视频', ['/cms/video/index'], ['target' => 'main'])?>
					<div class="hr_1"> </div>
					<?= Html::a('碎片', ['/cms/block/index'], ['target' => 'main'])?>
					<?= Html::a('自定义模块', ['/cms/diymodel/index'], ['target' => 'main'])?>
					<?= Html::a('自定义字段', ['/cms/diyfield/index'], ['target' => 'main'])?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu03');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 产品与订单</div>
				<div id="leftmenu03" style="display:none">
					<?= Html::a('产品分类', ['/shop/product-cate/index'], ['target' => 'main'])?>
					<?= Html::a('产品品牌', ['/shop/brand/index'], ['target' => 'main'])?>
					<?= Html::a('产品管理', ['/shop/product/index'], ['target' => 'main'])?>
					<div class="hr_1"> </div>
					<?= Html::a('订单管理', ['/shop/order/index'], ['target' => 'main'])?>
					<?= Html::a('配送设置', ['/shop/ship/index'], ['target' => 'main'])?>
					<?= Html::a('支付设置', ['/shop/pay/index'], ['target' => 'main'])?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu09');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 用户与咨询</div>
				<div id="leftmenu09" style="display:none">
					<?= Html::a('用户管理', ['/user/user/index'], ['target' => 'main'])?>
					<?= Html::a('用户收藏', ['/user/user-favorite/index'], ['target' => 'main'])?>
					<?= Html::a('用户评论', ['/user/user-comment/index'], ['target' => 'main'])?>
					<?= Html::a('投诉建议', ['/user/user-message/index'], ['target' => 'main'])?>
					<div class="hr_1"> </div>
					<?= Html::a('线上咨询', ['/user/user-inquiry/index'], ['target' => 'main'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/user/user-group/index'], ['target' => 'main', 'title' => '用户组管理', 'class' => 'menu-wrench group'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/user/user-level/index'], ['target' => 'main', 'title' => '用户等级管理', 'class' => 'menu-wrench level'])?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu02');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 扩展模块</div>
				<div id="leftmenu02" style="display:none">
					<?= Html::a('导航菜单', ['/ext/nav/index'], ['target' => 'main'])?>
					<?= Html::a('广告管理', ['/ext/ad/index'], ['target' => 'main'])?>
					<?= Html::a('友情链接', ['/ext/link/index'], ['target' => 'main'])?>
					<?= Html::a('招聘信息', ['/ext/job/index'], ['target' => 'main'])?>
					<?= Html::a('投票管理', ['/ext/vote/index'], ['target' => 'main'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/ext/ad-type/index'], ['target' => 'main', 'title' => '广告位管理', 'class' => 'menu-wrench ad-type'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/ext/link-type/index'], ['target' => 'main', 'title' => '友情链接类别', 'class' => 'menu-wrench link-type'])?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu04');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 系统管理</div>
				<div id="leftmenu04" style="display:none;"> 
    				<?= Html::a('管理员管理', ['/sys/admin/index'], ['target' => 'main'])?>
    				<?= Html::a('角色配置', ['/sys/role/index'], ['target' => 'main'])?>
    				<?= Html::a('模板管理', ['/sys/template/index'], ['target' => 'main'])?>
    				<?= Html::a('系统设置', ['/sys/config/setting'], ['target' => 'main'])?>
    				<?= Html::a('媒体中心', ['/sys/media/index'], ['target' => 'main'])?>
    				<div class="hr_1"> </div>
					<?= Html::a('数据库管理', ['/sys/db/index'], ['target' => 'main'])?>
    				<?= Html::a('级联数据', ['/sys/cascade/index'], ['target' => 'main'])?>
    				<?= Html::a('<i class="fa fa-wrench"></i>', ['/cms/flag/index'], ['target' => 'main', 'title' => '信息标记管理', 'class' => 'menu-wrench flag'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/cms/src/index'], ['target' => 'main', 'title' => '信息来源管理', 'class' => 'menu-wrench src'])?>
				</div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu06');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 辅助工具</div>
				<div id="leftmenu06" style="display:none;">
					<?= Html::a('文章抓取', ['/tool/spider/index'], ['target' => 'main'])?>
    				<?= Html::a('批量SEO优化', ['/tool/seo/index'], ['target' => 'main'])?>
    				<?= Html::a('通知与营销', ['/tool/notify/index'], ['target' => 'main'])?>
				</div>
			</div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu07');" title="点击切换显示或隐藏"><i class="fa fa-angle-right i1"></i><i class="fa fa-angle-down i2"></i> 日志与更新</div>
				<div id="leftmenu07" style="display:none;">
					<?= Html::a('操作日志', ['/sys/log/index'], ['target' => 'main'])?>
					<?= Html::a('开发日志', ['/sys/dev-log/index'], ['target' => 'main'])?>
					<div class="hr_1"> </div>
					<?= Html::a('教程分类', ['/site/help-cate/index'], ['target' => 'main'])?>
					<?= Html::a('教程管理', ['/site/help/index'], ['target' => 'main'])?>
					<?= Html::a('<i class="fa fa-wrench"></i>', ['/site/help-flag/index'], ['target' => 'main', 'title' => '教程标签管理', 'class' => 'menu-wrench help-flag'])?>
				</div>
			</div>
			<!--scrollbar end-->
		</div>
	</div>
</div>
<div class="bGradient"></div>