<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\helpers\Html;

JqueryAsset::register($this);

$js = <<<EOF
    $("#showad").html('<iframe src="./message.html" width="100%" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
EOF;

$this->registerJs($js);

$this->title = '首页概要';

$baseUrl = Yii::getAlias('@web');
?>
<div class="home-header">
	<div class="news">
		<div class="title">官方消息</div>
		<div id="showad"> </div>
	</div>
</div>

<div class="home-count">
	<div class="left-area">
		<div class="row-box quick-box">
			<h2 class="title">快捷操作<span><a href="<?= Url::to(['/site/lnk/index']) ?>">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="lnk-area box">
				<?php foreach ($lnkModels as $lnkModel) { ?>
				<?= Html::a($lnkModel->lnk_ico.' '.$lnkModel->lnk_name, $lnkModel->lnk_link, ['class' => 'lnk']) ?>
				<?php } ?>
				<div class="cl"></div>
			</div>
		</div>
		<div class="quick-box">
			<h2 class="title">系统配置<span><a href="javascript:;">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="box">
    			<table width="100%" border="0" cellspacing="0" cellpadding="0">
    				<tr>
    					<td height="33" colspan="2">服务器版本： <span><?= $_SERVER['SERVER_SOFTWARE']; ?></span></td>
    				</tr>
    				<tr>
    					<td width="50%" height="33">软件版本号： <span>v<?= Yii::$app->version ?></span></td>
    					<td width="50%">操作系统： <?= PHP_OS; ?></td>
    				</tr>
    				<tr>
    					<td height="33">PHP版本号： <?= PHP_VERSION; ?></td>
    					<td>GDLibrary： 
    						<?php if (extension_loaded('gd')) {
                                $gdInfo = gd_info();
                                echo $gdInfo['GD Version'];
                            } else {
                                echo '不支持';
                            } ?>
    					</td>
    				</tr>
    				<tr>
    					<td height="33">MySql版本： <?= Yii::$app->getDb()->getServerVersion() ?></td>
    					<td height="28">ZEND支持： 
    						<?php if (function_exists('zend_version')) {
    						    echo '支持';
    						} else {
    						    echo '不支持';
                            } ?>
    					</td>
    				</tr>
    				<tr class="nb">
    					<td height="33" colspan="2">支持上传的最大文件：
    					<?php 
    					$postMaxSize = ini_get('post_max_size');
    					$uploadMaxFileSize = ini_get('upload_max_filesize');
    					echo ($postMaxSize <= $uploadMaxFileSize)?$postMaxSize:$uploadMaxFileSize;
    					?>
    					</td>
    				</tr>
    			</table>
			</div>
		</div>
		<div class="quick-box">
			<h2 class="title">系统更新<span><a href="<?= Url::to(['/sys/dev-log/index']) ?>">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="box">
    			<ul>
    				<?php if($devLogModels) { ?>
    				<?php foreach ($devLogModels as $devLogModel) { ?>
    				<li><?= Yii::$app->getFormatter()->asDatetime($devLogModel->created_at, 'yyyy-MM-dd HH:mm') ?> 更新了新内容 “<?= $devLogModel->log_name ?>”</li>
    				<?php } ?>
        			<?php } ?>
    			</ul>
			</div>
		</div>
	</div>
	
	<div class="right-area">
		<div class="row-box quick-box">
			<h2 class="title">操作日志<span><a href="<?= Url::to(['/sys/log/index']) ?>">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="box">
				<ul>
				<?php if($logModels) { ?>
					<?php foreach ($logModels as $logModel) { ?>
    				<li><?= Yii::$app->getFormatter()->asDatetime($logModel->created_at, 'yyyy-MM-dd HH:mm') ?> 用户 <strong><?= $logModel->username ?></strong> 进行了 <span class="blue"><?= $logModel->name ?> [<?= $logModel->route ?>]</span> </li>
    				<?php } ?>
    			<?php } ?>
    			</ul>
			</div>
		</div>
		<div class="quick-box">
			<h2 class="title">发布统计<span><a href="<?= Url::to(['cms/column/index'])?>">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="box">
    			<table width="100%" border="0" cellspacing="0" cellpadding="0">
    				<tbody><tr>
    					<td width="80" height="33">网站栏目数：</td>
    					<td class="num">13</td>
    					<td width="80" height="33">网站栏目数：</td>
    					<td class="num">13</td>
    				</tr>
    				<tr>
    					<td height="33">单页信息数：</td>
    					<td class="num">5</td>
    					<td height="33">单页信息数：</td>
    					<td class="num">5</td>
    				</tr>
    				<tr>
    					<td height="33">列表信息数：</td>
    					<td class="num">19</td>
    					<td height="33">列表信息数：</td>
    					<td class="num">19</td>
    				</tr>
    				<tr>
    					<td height="33">图片信息数：</td>
    					<td class="num">15</td>
    					<td height="33">图片信息数：</td>
    					<td class="num">15</td>
    				</tr>
    				<tr class="nb">
    					<td height="33">注册会员数：</td>
    					<td class="num">1</td>
    					<td height="33">注册会员数：</td>
    					<td class="num">1</td>
    				</tr>
    			</tbody></table>
			</div>
		</div>
		<div class="quick-box">
			<h2 class="title">帮助中心<span><a href="<?= Url::to(['/site/help/index']) ?>">更多 <i class="fa fa-angle-double-right"></i></a></span></h2>
			<div class="box">
				<ul>
				<?php if($helpModels) { ?>
					<?php foreach ($helpModels as $helpModel) { ?>
    				<li><?= Yii::$app->getFormatter()->asDatetime($logModel->created_at, 'yyyy-MM-dd HH:mm') ?> 发布了新的帮助 <?= $helpModel->title ?></li>
    				<?php } ?>
    			<?php } ?>
    			</ul>
			</div>
		</div>
	</div>
	<div class="cl"></div>
</div>
<div class="home-copy"> 敬请您将在使用中发现的问题或者有好的建议告诉我们，以便改进。 <a href="http://www.turen2.com/feedback.html" target="_blank" class="feedback"><i class="fa fa-envelope-o"></i> 点击告诉我</a> | <a href="" class="doc">开发帮助</a> </div>
