<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\components\View;
use backend\widgets\Tips;

$this->title = '界面配置';

$js = <<<EOF
$('#tabs li:not(\'.line\')').on('click', function() {
    $('#tabs li').removeClass('on');
    $(this).addClass('on');
    var name = 'tabs_content_'+$(this).data('view');
    $('.tabs_content').hide();
    $('#'+name).show();
});
EOF;
$this->registerJs($js, View::POS_END);

//设置选项卡项
$configTabArr = [
    ['name' => '公共模块', 'view' => 'common'],
    ['name' => '首页模块', 'view' => 'home'],
    ['name' => '资讯模块', 'view' => 'news'],
    ['name' => '案例模块', 'view' => 'case'],
    ['name' => '业务模块', 'view' => 'service'],
    ['name' => '车型模块', 'view' => 'model'],
    ['name' => '问答模块', 'view' => 'qa'],
    ['name' => '帮助模块', 'view' => 'help'],
    ['name' => '登录模块', 'view' => 'login'],

	['name' => '手机模块', 'view' => 'mobile'],
    ['name' => '手机首页', 'view' => 'mhome'],
];

//统计当前数组数量
echo Tips::widget([
    'type' => 'error',
    'model' => $model,
    'closeBtn' => false,
]);
?>

<div class="config-form">
	<div class="toolbar-tab">
    	<ul id="tabs">
    		<?php
    		foreach($configTabArr as $index => $configTabText)
    		{
    			echo '<li data-view="'.$configTabText['view'].'" class="';
    			if($configTabText['view']  == 'common') echo 'on';
    			echo '"><a href="javascript:;">'.$configTabText['name'].'</a></li>';
    			if($index != count($configTabArr) - 1) {
                    echo '<li class="line">-</li>';
                }
    		}
    		?>
    	</ul>
    </div>

    <?php
    $form = ActiveForm::begin([
        'options' => [],
        'method' => 'POST',
        'action' => ['/site/face-config/batch'],
    ]);

	foreach($configTabArr as $configTabText) {
	?>
	<div class="tabs_content <?php if($configTabText['view'] != 'common') echo 'undis'; ?>" id="tabs_content_<?= $configTabText['view']; ?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table">
			<?= $this->render('_item/'.Yii::$app->language.'/_'.$configTabText['view'], [
                'config' => ArrayHelper::map($configs, 'cfg_name', 'cfg_value'),
            ]); ?>
			<tr class="nb">
				<td></td>
				<td>
    				<div class="form-sub-btn">
    					<input type="submit" class="submit" value="提交" />
    				</div>
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>