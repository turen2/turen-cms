<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use backend\models\user\Inquiry;
use backend\assets\FrameAsset;
use backend\filters\ReturnUrlFilter;
use backend\assets\FontAwesomeAsset;
use backend\models\sys\Multilang;
use backend\assets\MenuAsset;

/* @var $this \yii\web\View */
/* @var $content string */

YiiAsset::register($this);
FontAwesomeAsset::register($this);
FrameAsset::register($this);
MenuAsset::register($this);

$baseUrl = Yii::getAlias('@web');
$js = <<<EOF
var fun = $('.fun');
var link = fun.find('.message-alert');
var droplist = $('.message-alert-box');

link.mouseover(function () {
    if (droplist.is(":hidden")) {
        droplist.show().css("left", 140);
    }
});
fun.mouseleave(function () {
    droplist.hide();
});
EOF;
$this->registerJs($js);

//用户相关，重点注意
if (Yii::$app->user->getIsGuest()) {
    return;//后面的代码将不再执行，返回void
}

$adminModel = Yii::$app->user->identity;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title.' - '.Yii::$app->name)?></title>
        <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
        <?php $this->head() ?>
        <?= $this->render('_config') ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="header">
        	<a href="javascript:;" id="logo" class="logo"></a>
        	<div class="user">
        		<div class="user-panel">
        			<a href="javascript:;" class="arrow"><?= !empty(Yii::$app->params['config_site_name'])?Yii::$app->params['config_site_name']:'这里是站点名称' ?> <i class="fa fa-angle-down i1"></i><i class="fa fa-angle-up i2"></i></a>
        			<div class="panel">
        				<div class="warp">
        					<div class="txt">当前身份：<?= $adminModel->username ?> ~ <?= $adminModel->roleName ?></div>
							<div class="info">
        						<div><strong>上次登录</strong><br><?= Yii::$app->getFormatter()->asDatetime($adminModel->logintime, 'yyyy-dd-MM HH:mm') ?></div>
        						<div><strong>本次登录</strong><br><?= Yii::$app->getFormatter()->asDatetime($adminModel->updated_at, 'yyyy-dd-MM HH:mm') ?>&nbsp;&nbsp;<?= $adminModel->loginip ?></div>
        					</div>
        					<div class="actbtn"><a href="<?= Url::to(['/sys/admin/update', 'id' => $adminModel->getId()]) ?>" class="edit" target="main">修改密码</a><a href="<?= Url::to(['/site/admin/logout']) ?>" data-method="post" class="logout">退出(ESC)</a></div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<div class="fun">
                <div class="site-list clearfix">
                    <?php 
                    $multilangModels = Multilang::find()->orderBy(['orderid' => SORT_DESC])->all();
                    if($multilangModels) {
                        foreach ($multilangModels as $multilangModel) {
                            $options = [
                                'data-params' => ['lang' => $multilangModel->lang_sign],//此参数是用来构造表单的post参数
                                'data-method' => 'post',
                                'class' => (GLOBAL_LANG == $multilangModel->lang_sign)?'on':'',
                                'title' => '切换到',
                            ];
                            echo Html::a($multilangModel->lang_name, Url::current(), $options);
                        }
                        
                        echo Html::a(' | ', 'javascript:;');
                    }
                    ?>
            	</div>
                <?php
                $inquiryNum = 0;
                $feedbackNum = 0;
                $notifyNum = $inquiryNum + $feedbackNum;
                ?>
            	<a href="javascript:;" class="message-alert df" title="消息提醒"><i class="fa fa-bell-o"></i><span class="label label-danger"><?= $notifyNum ?></span></a>
        		<a href="<?= Yii::$app->params['config_site_url'] ?>" target="_blank" class="home-link df" title="网站首页"><i class="fa fa-desktop"></i></a>
        		<a href="javascript:;" id="lockscreen" class="lock-screen df" title="锁屏"><i class="fa fa-lock"></i></a>
        		<a href="http://www.turen2.com/" target="_blank" class="web-link df" title="土人开源系统"><i class="fa fa-life-ring"></i></a>

                <div class="message-alert-box">
                    <div class="message-box br5">
                        <a target="main" href="<?= Url::to(['/user/inquiry/index']) ?>">在线预约(<?= $inquiryNum ?>)</a>
                        <a target="main" href="<?= Url::to(['/user/feedback/index']) ?>">问题反馈(<?= $feedbackNum ?>)</a>
                    </div>
                </div>

                <?php // $this->render('//layouts/_nav.php', [], $this->context) //alias、//主题路径、当前模块路径、相对路径 ?>
        	</div>
        </div>
        
        <div class="left">
        	<div class="menu">
                <?= $this->render('_menu') ?>
        	</div>
        </div>
        <div class="right">
        	<div class="main">
        		<?php //持久层，记录当前的访问页面 ?>
        		<iframe name="main" id="main" frameborder="0" src="<?= (Yii::$app->getSession()->has(ReturnUrlFilter::RETURN_RUL_ROUTE))?Yii::$app->getSession()->get(ReturnUrlFilter::RETURN_RUL_ROUTE):Url::to(['/site/home/default']) ?>"></iframe>
        	</div>
        </div>
        
        <div class="lock-screen-bg">
        	<div class="win-box">
        		<div class="pwd">
        			解锁密码：
        			<div><input type="password" name="password" id="password" />
        				<span onclick="CheckPwd()" class="btn">确 定</span></div>
        			<span class="note">&nbsp;</span>
        		</div>
        	</div>
        	<div class="copyright">&copy; 2016-<?= date('Y')?> v<?= Yii::$app->version?></div>
        </div>
        <?php 
        //yii菜单功能强大，能灵活实现任意的菜单模式
        /*
        echo Menu::widget([
            //全局设置
            'encodeLabels' => false,
            'activateParents' => true,
            'options' => ['class' => 'nav', 'id' => 'side-menu'],
            'submenuTemplate' => '<ul class="nav nav-second-level">{items}</ul>',
            'itemOptions' => [],//子菜单属性
            'linkTemplate' => '<a href="{url}" class="J_menuItem">{label}</a>',
            
            //局部设置
            'items' => $this->renderMenus(),
            //在子菜单中重新覆盖如下模板！！！
            //submenuTemplate,//'<ul class="nav nav-second-level">{items}</ul>',
            //template,//'<a href="{url}" class="J_menuItem">{label}</a>',
        ]);
        */
        ?>
        <?php //echo $content ?>
    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>